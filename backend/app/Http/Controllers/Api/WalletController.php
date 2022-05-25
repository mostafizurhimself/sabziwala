<?php

namespace App\Http\Controllers\Api;

use App\Facades\Helper;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Library\WalletHandler;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddMoneyRequest;
use App\Models\Transaction;

class WalletController extends Controller
{
    /**
     * Get the current customer transactions
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transaction(Request $request)
    {
        return ApiResource::collection(Transaction::with('order')->where('customer_id', auth()->user()->id)->filter($request->all())->sorted()->paginate(10));
    }

    /**
     * Add money to the customer wallet
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addMoney(AddMoneyRequest $request, WalletHandler $walletHandler)
    {
        $customer = Customer::find(auth()->user()->id);
        DB::transaction(function () use ($customer, $request, $walletHandler) {
            $walletHandler->charge($request->amount, Helper::getCurrencyCode(), $request->token, "Money added by $customer->id");
            $walletHandler->createTransaction($request->amount);
            $customer->increment('balance', $request->amount);
        });

        return new ApiResource($customer);
    }



}
