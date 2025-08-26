<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\CartItem;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CartItemController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     * Lấy danh sách giỏ hàng của user hiện tại
     */
    public function index()
    {
        try {
            $user = Auth::user();

            $carts = CartItem::with(['course' => function ($query) {
                $query
                    ->where('status', true); // Chỉ lấy course đang active
            }])
                ->where('user_id', $user->id)->orderBy('id', 'desc')
                // 	Lọc model cha dựa vào điều kiện trong model con => là đảm bảo có ít nhất 1 course đang active
                ->whereHas('course', function ($query) {
                    $query->where('status', true); // Đảm bảo course vẫn còn active
                }) // Ẩn user_id nếu không cần thiết
                ->get();
            $carts->each(function ($item) {
                $item->course?->makeHidden(['description', 'intro_video', 'created_at', 'updated_at', 'is_favorite']);
            });
            // Tính tổng tiền
            $totalAmount = $carts->sum('price_snapshot');
            $totalItems = $carts->count();

            return $this->successResponse([
                'items' => $carts,
                'summary' => [
                    'total_items' => $totalItems,
                    'total_amount' => $totalAmount
                ]
            ], 'Lấy giỏ hàng thành công');
        } catch (\Exception $e) {

            return $this->errorResponse(null, $e, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * Thêm khóa học vào giỏ hàng
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|exists:courses,id'
            ]);

            $user = Auth::user();
            $courseId = $request->course_id;

            // Kiểm tra course có tồn tại và đang active không
            $course = Course::where('id', $courseId)
                ->where('status', true)
                ->first();

            if (!$course) {
                return $this->errorResponse(null, 'Khóa học không tồn tại hoặc đã ngừng hoạt động', 404);
            }

            // Kiểm tra user đã đăng ký khóa học này chưa
            $isEnrolled = CourseEnrollment::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->exists();

            if ($isEnrolled) {
                return $this->errorResponse(null, 'Bạn đã đăng ký khóa học này rồi');
            }

            // Kiểm tra khóa học đã có trong giỏ hàng chưa
            $existingCartItem = CartItem::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->first();

            if ($existingCartItem) {
                return $this->errorResponse(null, 'Khóa học đã có trong giỏ hàng');
            }
            // Kiểm tra xem đã có trong hóa đơn nào (trạng thái pending)  -> Không cho thêm nữa
            // $hasPendingInvoice = Invoice::where('user_id', $user->id)
            //     ->where('status', 'pending')
            //     ->whereHas('items', function ($query) use ($courseId) {
            //         $query->where('course_id', $courseId);
            //     })
            //     ->exists();

            // if ($hasPendingInvoice) {
            //     return $this->errorResponse(null, 'Khóa học này đã có trong hóa đơn đang chờ thanh toán!');
            // }

            // Thêm vào giỏ hàng
            $cart = CartItem::create([
                'user_id' => $user->id,
                'course_id' => $courseId,
                'price_snapshot' => $course->final_price
            ]);

            $cart->load('course');
            $user->logActivity("add_to_cart", "Đã thêm khóa học \"{$cart->course->name}\" vào giỏ hàng");
            return $this->successResponse($cart, 'Đã thêm khóa học vào giỏ hàng', 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi thêm vào giỏ hàng', 500);
        }
    }

    /**
     * Display the specified resource.
     * Xem chi tiết một item trong giỏ hàng
     */
    public function show(CartItem $cart)
    {
        // return $this->errorResponse(null, 'Bạn không có quyền xem item này', 403);

        try {
            $user = Auth::user();

            // Kiểm tra quyền sở hữu
            if ($cart->user_id !== $user->id) {
                return $this->errorResponse(null, 'Bạn không có quyền xem item này', 403);
            }

            $cart->load('course');

            return $this->successResponse($cart, 'Lấy thông tin item thành công');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi lấy thông tin item', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * Cập nhật giá snapshot (trong trường hợp giá khóa học thay đổi)
     */
    public function update(Request $request, CartItem $cart)
    {
        try {
            $user = Auth::user();

            // Kiểm tra quyền sở hữu
            if ($cart->user_id !== $user->id) {
                return $this->errorResponse(null, 'Bạn không có quyền cập nhật item này', 403);
            }

            // Cập nhật giá theo giá hiện tại của khóa học
            $course = Course::find($cart->course_id);

            if (!$course || !$course->status) {
                return $this->errorResponse(null, 'Khóa học không còn khả dụng');
            }

            $cart->update([
                'price_snapshot' => $course->price
            ]);

            $cart->load('course');

            return $this->successResponse($cart, 'Đã cập nhật giá khóa học');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi cập nhật item', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * Xóa khóa học khỏi giỏ hàng
     */
    public function destroy(CartItem $cart)
    {
        try {
            $user = Auth::user();

            // Kiểm tra quyền sở hữu
            if ($cart->user_id !== $user->id) {
                return $this->errorResponse(null, 'Bạn không có quyền xóa item này' . $user->id . " " . $cart->user_id, 403);
            }

            $courseName = $cart->course->name ?? 'Khóa học';
            $cart->delete();

            return $this->successResponse(null, "Đã xóa '{$courseName}' khỏi giỏ hàng");
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi xóa item', 500);
        }
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        try {
            $user = Auth::user();

            $deletedCount = CartItem::where('user_id', $user->id)->delete();

            return $this->successResponse(null, "Đã xóa {$deletedCount} item khỏi giỏ hàng");
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi xóa giỏ hàng', 500);
        }
    }

    /**
     * Kiểm tra và làm sạch giỏ hàng (xóa các course không còn khả dụng)
     */
    public function cleanup(Request $request)
    {
        try {
            // Xác thực: yêu cầu cart_id là một mảng
            $validated = $request->validate([
                'cart_id' => 'required|array',
                'cart_id.*' => 'integer', // từng phần tử phải là số nguyên
            ]);

            $user = Auth::user();

            // Chỉ xóa cart thuộc về user hiện tại
            $deletedCount = CartItem::whereIn('id', $validated['cart_id'])
                ->where('user_id', $user->id)
                ->delete();

            return $this->successResponse(
                null,
                "Đã xóa thành công {$deletedCount} mục khỏi giỏ hàng."
            );
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi xóa giỏ hàng', 500);
        }
    }

    // Toggle một item (chuyển đổi trạng thái)
    public function toggleActive(Request $request, CartItem $cart)
    {
        try {
            $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $user = Auth::user();


            // Kiểm tra quyền sở hữu
            if ($cart->user_id !== $user->id) {
                return $this->errorResponse(null, 'Bạn không có quyền cập nhật item này', 403);
            }

            // Kiểm tra trạng thái khóa học
            if (!$cart->course || !$cart->course->status) {
                return $this->errorResponse(null, 'Khóa học không còn khả dụng', 404);
            }

            // Toggle trạng thái
            $cart->is_active = $request->is_active;
            $cart->save();

            return $this->successResponse($cart, 'Đã cập nhật trạng thái hoạt động của item');
        } catch (\Throwable $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi cập nhật trạng thái hoạt động', 500);
        }
    }

    // Kích hoạt tất cả item có thể
    public function toggleAll(Request $request)
    {
        try {
            $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $user = Auth::user();
            $targetStatus = $request->is_active;

            // Cập nhật những cart item:
            // - Thuộc về user
            // - Khác với trạng thái mong muốn
            // - Khóa học còn hoạt động
            $updatedCount = CartItem::where('user_id', $user->id)
                ->where('is_active', '!=', $targetStatus)
                ->whereHas('course', function ($query) {
                    $query->where('status', true);
                })
                ->update(['is_active' => $targetStatus]);

            return $this->successResponse(
                ['updated_count' => $updatedCount],
                "Đã cập nhật {$updatedCount} item trong giỏ hàng thành trạng thái " . ($targetStatus ? 'active' : 'inactive')
            );
        } catch (\Throwable $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi cập nhật tất cả item', 500);
        }
    }

    // Hiển thị thông tin tóm tắt giỏ hàng như: Tổng số bài học, Tổng thời lượng, Tổng đánh giá TB, thành tiền
    // Người dùng sẽ gửi lên dạng id cart [1,2,3] để lấy summary
    public function summary(Request $request)
    {
        try {
            $request->validate([
                'cart_id' => 'array',
                'cart_id.*' => 'integer|exists:cart_items,id', // từng phần tử phải là số nguyên và tồn tại trong bảng cart_items
            ]);
            $cartItems = CartItem::where('user_id', Auth::id())
                ->whereIn('id', $request->cart_id)
                ->with('course.reviews', 'course.chapters.lessons') // load hết liên quan
                ->get();

            $totalLessons = 0;
            $totalDuration = 0;
            $totalRating = 0;
            $totalRatingCount = 0;
            $totalPrice = 0;

            foreach ($cartItems as $item) {
                $course = $item->course;

                $totalLessons += $course->lesson_count ?? 0;
                $totalDuration += $course->duration ?? 0;

                $ratingData = $course->rating;
                $totalRating += ($ratingData['average_rating'] ?? 0) * ($ratingData['total_reviews'] ?? 0);
                $totalRatingCount += $ratingData['total_reviews'] ?? 0;

                $totalPrice += $item->price_snapshot ?? $course->price ?? 0;
            }

            $averageRating = $totalRatingCount > 0 ? round($totalRating / $totalRatingCount, 1) : 0;


            return $this->successResponse([
                'total_lessons' => $totalLessons,
                'total_duration' => $totalDuration,
                'average_rating' => $averageRating,
                'total_price' => $totalPrice,
            ], 'Lấy thông tin tóm tắt giỏ hàng thành công!');
        } catch (\Exception $e) {
            return $this->errorResponse(null, 'Có lỗi xảy ra khi lấy thông tin tóm tắt giỏ hàng', 500);
        }
    }

    // Checkout
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:transfer,vnpay,momo,zalopay,card'
        ]);

        $user = Auth::user();
        // 1. Lấy các khóa học trong giỏ còn active
        $cartItems = CartItem::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        if ($cartItems->isEmpty()) {
            return $this->errorResponse(null, 'Giỏ hàng trống hoặc không có khóa học nào còn hoạt động.', 400);
        }

        // 2. Tính tổng tiền
        $total = $cartItems->sum('price_snapshot');

        DB::beginTransaction();

        try {
            // 2. Tính tổng tiền
            $total = $cartItems->sum('price_snapshot');

            // Nếu user có tiền trong tài khoản, ưu tiên trừ vào tổng tiền
            if ($user->money > 0) {
                if ($user->money >= $total) {
                    // Đủ tiền, trừ hết và set tổng tiền còn lại = 0
                    $user->decrement('money', $total);
                    $total = 0;
                } else {
                    // Không đủ, trừ hết số tiền hiện có, phần còn lại phải thanh toán
                    $total -= $user->money;
                    $user->decrement('money', $user->money);
                }
            }


            // 3. Tạo hóa đơn
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'payment_method' => $request->payment_method,
                'total_price' => $total,
            ]);

            // 4. Tạo invoice_items
            foreach ($cartItems as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'course_id' => $item->course_id,
                    'price_snapshot' => $item->price_snapshot,
                ]);
            }

            // 5. Xóa cart_items sau khi checkout
            CartItem::where('user_id', $user->id)
                ->where('is_active', true)
                ->delete();

            DB::commit();
            if ($request->payment_method === 'vnpay') {
                return app(VnpayController::class)->createPayment($request, $invoice->transaction_code);
            } else if ($request->payment_method === 'momo') {
                // Tạo liên kết thanh toán MoMo
                return app(MomoController::class)->createPayment($request, $invoice->transaction_code);
            } else if ($request->payment_method === 'zalopay') {
                // Tạo liên kết thanh toán ZaloPay
                return app(ZaloPayController::class)->createPayment($request, $invoice->transaction_code);
            }
            $user->logActivity("create_invoice", "Đã tạo hóa đơn \"{$invoice->transaction_code}\".");
            return $this->successResponse($invoice, 'Đã tạo hóa đơn thành công. Vui lòng thanh toán');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(null, 'Đã xảy ra lỗi khi tạo hóa đơn ' . $e->getMessage(), 500);
        }
    }
}
