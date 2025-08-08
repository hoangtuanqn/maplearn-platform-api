<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceController extends BaseApiController
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $invoices = QueryBuilder::for(Invoice::class)

            ->allowedSorts(['created_at', 'updated_at'])
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->paginate(10);

        return $this->successResponse($invoices, 'Lấy danh sách hóa đơn thành công!');
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
        // Check các course trong invoice này (Nếu có kcais nào ko tồn tại hoặc status = false thì hủy hóa đơn luôn)
        $invoice->items->where('status', 'pending')->each(function ($item) use ($invoice) {
            if (!$item->course || !$item->course->status) {
                $invoice->status = 'failed';
                $invoice->note = 'Hệ thống: Hóa đơn này đã bị hủy do có khóa học không còn khả dụng.';
                $invoice->save();
                return;
            }
        });

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

    // Cancel hóa đơn
    public function cancel(Invoice $invoice)
    {
        $this->authorize('cancel', $invoice);

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
}
