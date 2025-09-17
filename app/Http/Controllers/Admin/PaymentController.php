<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PaymentController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = (int)($request->limit ?? 20);

        $payments = QueryBuilder::for(Payment::class)
            ->allowedFilters([
                "search",
                "payment_method",
                "status",
                // "date_from",
                // "date_to",
                AllowedFilter::partial('search', 'username.full_name'),
                AllowedFilter::callback('amount_min', function ($query, $value) {
                    if ($value !== null && $value !== '') {
                        $query->where('amount', '>=', (float) $value);
                    }
                }),
                AllowedFilter::callback('amount_max', function ($query, $value) {
                    if ($value !== null && $value !== '') {
                        $query->where('amount', '<=', (float) $value);
                    }
                }),
                AllowedFilter::callback('date_from', function ($query, $value) {
                    if ($value !== null && $value !== '') {
                        $query->whereDate('paid_at', '>=', $value);
                    }
                }),
                AllowedFilter::callback('date_to', function ($query, $value) {
                    if ($value !== null && $value !== '') {
                        $query->whereDate('paid_at', '<=', $value);
                    }
                }),
            ])
            ->where('status', 'paid') // Example: only show completed or canceled payments
            ->with(['user:id,full_name,username', 'course:id,name,slug']) // Eager load relationships if needed
            ->orderByDesc('id')
            ->paginate($limit);

        return $this->successResponse($payments, 'Lấy danh sách thanh toán thành công!');
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
    public function show(Payment $payment)
    {
        return $this->successResponse($payment, 'Lấy thông tin thanh toán thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        // Chỉ update status
        $data = $request->validate([
            'status' => 'required|in:pending,paid,canceled',
        ]);
        $payment->status = $data['status'];
        $payment->save();
        return $this->successResponse($payment, 'Cập nhật trạng thái thanh toán thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
