<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\RefundRequest;
use Illuminate\Validation\Rule;
use App\Enums\RefundRequestStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RefundRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', RefundRequest::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Refunds/Index', [
            'refunds' => RefundRequest::with('order', 'customer')
                ->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'query' => $request->all(),
            'statusFilterOptions'  => RefundRequestStatus::toSelectOptions(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->user()->cannot('create', RefundRequest::class)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->user()->cannot('create', RefundRequest::class)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return \Illuminate\Http\Response
     */
    public function show(RefundRequest $refundRequest)
    {
        if (request()->user()->cannot('view', $refundRequest)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Refunds/Show', [
            'refundRequest' => $refundRequest->load('customer', 'order'),
            'refundStatusOptions' => RefundRequestStatus::toSelectOptions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefundRequest $refundRequest)
    {
        if (request()->user()->cannot('update', $refundRequest)) {
            abort(403);
        }

        // Start from here ...
        $this->validate($request, [
            'status' => ['required', Rule::in(RefundRequestStatus::toArray())]
        ]);

        DB::transaction(function () use ($refundRequest, $request) {

            $refundRequest->update([
                'status' => $request->status
            ]);

            if ($request->status == RefundRequestStatus::ACCEPTED()) {
                // Refund money to customer
                $transaction = Transaction::create([
                    'customerId'  => $refundRequest->order->customerId,
                    'orderId'     => $refundRequest->orderId,
                    'amount'      => $refundRequest->order->grandTotal,
                    'method'      => PaymentMethod::WALLET(),
                    'description' => "Refund for {$refundRequest->order->invoiceNo}",
                ]);

                $transaction->customer->updateBalance();

                // Update the order status
                $refundRequest->order->update([
                    'status' => OrderStatus::REFUNDED()
                ]);
            }
        });


        session()->flash('flash.banner', 'Status updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefundRequest $refundRequest)
    {
        if (request()->user()->cannot('delete', $refundRequest)) {
            abort(403);
        }

        // Start from here ...
    }
}
