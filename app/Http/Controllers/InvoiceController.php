<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceController extends BaseApiController
{
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
        $user = Auth::user();
        if ($invoice->user_id !== $user->id) {
            return $this->errorResponse('Bạn không có quyền truy cập vào hóa đơn này.', 403);
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
}
