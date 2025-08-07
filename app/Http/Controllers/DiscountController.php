<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\CartItem;

class DiscountController extends BaseApiController
{

    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = Auth::user();
        $code = $request->code;

        $discount = Discount::where('code', $code)
            ->where('is_active', true)
            ->where(function ($q) {
                $now = now();
                $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) {
                $now = now();
                $q->whereNull('end_date')->orWhere('end_date', '>=', $now);
            })
            ->first();

        if (!$discount) {
            return $this->errorResponse('Mã giảm giá không hợp lệ hoặc đã hết hạn.', 400);
        }

        // Lấy giỏ hàng
        $cartItems = CartItem::with('course')
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        if ($cartItems->isEmpty()) {
            return $this->errorResponse('Giỏ hàng trống.', 400);
        }

        $totalPrice = $cartItems->sum('price_snapshot');
        $conditions = json_decode($discount->conditions, true) ?? [];

        // Kiểm tra điều kiện
        if (isset($conditions['grade']) && !in_array($user->grade ?? null, $conditions['grade'])) {
            return $this->errorResponse('Mã này chỉ áp dụng cho một số khối lớp.', 400);
        }

        if (!empty($conditions['first_order'])) {
            $hasOrder = $user->orders()->exists(); // cần quan hệ orders()
            if ($hasOrder) {
                return Response::json([
                    'success' => false,
                    'message' => 'Mã này chỉ áp dụng cho đơn hàng đầu tiên.',
                ]);
            }
        }

        if (isset($conditions['min_total_price']) && $totalPrice < $conditions['min_total_price']) {
            return Response::json([
                'success' => false,
                'message' => 'Tổng đơn hàng chưa đủ để áp dụng mã.',
            ]);
        }

        if (!empty($conditions['combo_courses'])) {
            $cartCourseIds = $cartItems->pluck('course_id')->toArray();
            $missing = array_diff($conditions['combo_courses'], $cartCourseIds);
            if (!empty($missing)) {
                return Response::json([
                    'success' => false,
                    'message' => 'Bạn cần mua đủ khóa học combo để áp mã.',
                ]);
            }
        }

        if (!empty($conditions['course_ids'])) {
            $cartCourseIds = $cartItems->pluck('course_id')->toArray();
            if (!array_intersect($conditions['course_ids'], $cartCourseIds)) {
                return Response::json([
                    'success' => false,
                    'message' => 'Mã không áp dụng cho các khóa trong giỏ.',
                ]);
            }
        }
        if (!empty($conditions['subject_id'])) {
            $cartSubjectIds = $cartItems->pluck('id')->toArray();
            if (!array_intersect($conditions['subject_id'], $cartSubjectIds)) {
                return Response::json([
                    'success' => false,
                    'message' => 'Mã không áp dụng cho các khóa trong giỏ.',
                ]);
            }
        }

        if (!empty($conditions['referral_user'])) {
            if (!$user->referred_by) { // cần cột `referred_by` trong bảng users
                return Response::json([
                    'success' => false,
                    'message' => 'Mã này chỉ áp dụng cho người được giới thiệu.',
                ]);
            }
        }

        // Tính giá trị giảm
        $discountAmount = 0;

        if ($discount->type === 'percentage') {
            $discountAmount = round($totalPrice * ($discount->value / 100), 2);
        } else {
            $discountAmount = $discount->value;
        }

        $finalTotal = max(0, $totalPrice - $discountAmount);

        // Tính final_price cho từng item
        $cartWithFinalPrice = [];

        $targetCourseIds = $conditions['course_ids'] ?? null;
        $itemsToDiscount = $cartItems;

        if ($targetCourseIds) {
            $itemsToDiscount = $cartItems->filter(function ($item) use ($targetCourseIds) {
                return in_array($item->course_id, $targetCourseIds);
            });
        }

        $countItemsToDiscount = max(1, $itemsToDiscount->count());
        $perItemDiscount = round($discountAmount / $countItemsToDiscount, 2);

        foreach ($cartItems as $item) {
            $isDiscounted = $itemsToDiscount->contains('id', $item->id);
            $finalPrice = $item->price_snapshot;

            if ($isDiscounted) {
                $finalPrice = max(0, $finalPrice - $perItemDiscount);
            }

            $cartWithFinalPrice[] = [
                'id' => $item->id,
                'course_id' => $item->course_id,
                'price_snapshot' => $item->price_snapshot,
                'final_price' => $finalPrice,
                'course_name' => $item->course->name,
                'course_thumbnail' => $item->course->thumbnail,
            ];
        }

        return Response::json([
            'success' => true,
            'discount_value' => $discountAmount,
            'message' => 'Áp dụng mã thành công.',
            'final_total' => $finalTotal,
            'cart_items' => $cartWithFinalPrice,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        //
    }
}
