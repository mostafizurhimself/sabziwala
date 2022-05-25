<?php

namespace App\Http\Controllers\Api;

use App\Facades\Response;
use Illuminate\Http\Request;
use App\Models\RefundRequest;
use App\Enums\RefundRequestStatus;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRefundRequest;


class RefundRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ApiResource::collection(RefundRequest::with('order')->filter($request->all())->where('customer_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRefundRequest $request)
    {
        $refundRequest = RefundRequest::create([
            'customerId'            => auth()->user()->id,
            'orderId'               => $request->orderId,
            'reason'                => $request->reason,
        ]);

        return new ApiResource($refundRequest);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerRefundRequest $refundRequest)
    {
        if (auth()->user()->id == $refundRequest->customerId) {
            return new ApiResource($refundRequest);
        } else {
            return Response::unauthorized('Unauthorized', 403);
        }
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
        if ($refundRequest->status == RefundRequestStatus::PENDING()) {

            $refundRequest->update([
                'reason'                => $request->reason,
            ]);
            return new ApiResource($refundRequest);
        }

        return Response::unauthorized('You can not update it now.', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefundRequest $refundRequest)
    {

        if ($refundRequest->status == RefundRequestStatus::PENDING()) {
            $refundRequest->delete();
            return new ApiResource($refundRequest);
        }
        return Response::success('Refund request delete successfully', 200);
    }
}