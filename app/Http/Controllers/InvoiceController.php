<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\CardTopup;
use App\Models\CourseEnrollment;
use App\Models\Invoice;
use App\Services\CardTopupService;
use App\Traits\AuthorizesOwnerOrAdmin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceController extends BaseApiController
{
    use AuthorizesRequests, AuthorizesOwnerOrAdmin;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = Auth::user();
        // $invoices = QueryBuilder::for(Invoice::class)

        //     ->allowedSorts(['created_at', 'updated_at'])
        //     ->where('user_id', $user->id)
        //     ->orderByDesc('id')
        //     ->paginate(10);

        // return $this->successResponse($invoices, 'Lấy danh sách hóa đơn thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        Gate::authorize('admin-owner', $invoice);
        // Lấy tất cả items và load course liên quan
        $items = $invoice->items()->with('course')->get();

        $hasInvalidCourse = false;
        // Kiểm tra khóa học còn khả dụng hay không ?
        foreach ($items as $item) {
            // Nếu course không tồn tại hoặc không còn khả dụng
            if (!$item->course || !$item->course->status) {
                $hasInvalidCourse = true;
                break;
            }
        }

        if ($hasInvalidCourse) {
            $invoice->status = 'failed';
            $invoice->note = 'Hệ thống: Hóa đơn này đã bị hủy do có khóa học không còn khả dụng.';
            $invoice->save();
            // Reload lại invoice để trả về trạng thái mới nhất
            $invoice->load(['items.course']);
            return $this->successResponse($invoice, 'Lấy thông tin hóa đơn thành công!');
        }
        $totalDeducted = 0;
        // Hóa đơn là chờ xử lý thì check các khóa nào trong hóa đơn, xem khóa học nào đã được mua từ trước thì trừ ra
        if ($invoice->status === 'pending') {
            // Lấy danh sách course_id mà user đã mua
            $enrolledCourseIds = CourseEnrollment::where('user_id', $invoice->user_id)
                ->pluck('course_id')
                ->toArray();
            foreach ($items as $item) {
                if ($item->price_snapshot > 0 && in_array($item->course_id, $enrolledCourseIds)) {
                    $totalDeducted += $item->price_snapshot;
                    $item->price_snapshot = 0;
                    $item->save();
                }
            }
            if ($totalDeducted > 0) {

                if ($invoice->total_price - $totalDeducted == 0) {
                    $invoice->status = 'paid';
                    $invoice->note = 'Hệ thống: Hóa đơn này đã được thanh toán tự động do bạn đã mua khóa học trước đó.';
                } else {
                    $invoice->total_price -= $totalDeducted;
                }
                $invoice->save();
            }
        }
        $invoice->load(['items.course']);

        return $this->successResponse($invoice, 'Lấy thông tin hóa đơn thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    // confirm hóa đơn
    // public function confirm(Invoice $invoice)
    // {
    //     $invoice->status = 'paid';
    //     $invoice->save();
    //     // $invoice->user->purchasedCourses()->attach([1,2]);
    //     return $this->successResponse($invoice, 'Hóa đơn đã được xác nhận thành công!');
    // }

    // Cancel hóa đơn
    public function cancel(Invoice $invoice)
    {
        $this->authorize('admin-owner', $invoice);

        if ($invoice->status !== 'pending') {
            return $this->errorResponse(null, 'Chỉ có thể hủy hóa đơn đang chờ xử lý.', 400);
        }

        $invoice->status = 'failed';

        $invoice->save();

        return $this->successResponse($invoice, 'Hóa đơn đã được hủy thành công!');
    }

    // Kiểm tra hóa đơn
    public function checkInvoice(Request $request, Invoice $invoice)
    {
        $this->authorize('admin-owner', $invoice);
        switch ($invoice->payment_method) {
            case 'momo':
                return app(MomoController::class)->createPayment($request, $invoice->transaction_code);
            case 'vnpay':
                return app(VnpayController::class)->createPayment($request, $invoice->transaction_code);
            case 'zalopay':
                return app(ZalopayController::class)->createPayment($request, $invoice->transaction_code);
            default:
                return $this->errorResponse(null, 'Trạng thái hóa đơn không hợp lệ.', 400);
        }

        return $this->successResponse($invoice, 'Kiểm tra hóa đơn thành công!');
    }

    public function payWithCard(Request $request, Invoice $invoice)
    {
        $this->authorize('admin-owner', $invoice);
        $validated = $request->validate([
            'cards' => 'required|array|min:1',
            'cards.*.telco' => 'required|string|max:50',
            'cards.*.amount' => 'required|integer|min:1000',
            'cards.*.serial' => 'required|string|max:100',
            'cards.*.code' => 'required|string|max:100',
        ]);
        $res = [];
        foreach ($validated['cards'] as $card) {
            $res[] = CardTopupService::cardToPartner($card);
        }
        // Xử lý logic, sai hết, sai 1 vài thẻ, ko sai thẻ nào
        $allSuccess = true;
        $someFailed = false;

        // Lưu vô lịch sử
        foreach ($res as $card) {

            if ($card['status'] == 1 || $card['status'] == 99) {
                CardTopup::create([
                    'user_id' => $request->user()->id,
                    'invoice_id' => $invoice->id,
                    'network' => $card['telco'],
                    'amount' => $card['declared_value'],
                    'serial' => $card['serial'],
                    'code' => $card['code'],
                    'status' => $card['status'] == 1 ? 'success' : 'pending',
                    'request_id' => $card['request_id'] ?? null,
                    'response_message' => $card['message']
                ]);
            }

            if ($card['status'] !== 1) {
                $allSuccess = false;
                if ($card['status'] === 99) {
                    $someFailed = true;
                }
            }
        }

        if ($allSuccess) {
            return $this->successResponse($res, 'Tất cả thẻ đã được nạp thành công!');
        } elseif ($someFailed) {
            return $this->successResponse($res, 'Một số thẻ đã gửi thành công, vui lòng kiểm tra lại!');
        } else {
            return $this->errorResponse($res, 'Tất cả thẻ nạp thất bại, vui lòng kiểm tra lại!');
        }

        return $this->successResponse($res, 'Thanh toán bằng thẻ cào thành công!');
    }

    // Get Card đã nạp trong invoice này
    public function getCards(Request $request, Invoice $invoice)
    {
        Gate::authorize('admin-owner', $invoice);
        $limit = min($request->input('limit', 10), 100);
        // Gate::authorize('view-cards', $invoice);
        $cards = QueryBuilder::for($invoice->cards())
            ->orderByDesc('id')
            ->paginate($limit);
        return $this->successResponse($cards, 'Lấy danh sách thẻ thành công!');
    }
}
