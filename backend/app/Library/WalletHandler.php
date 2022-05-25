<?php

namespace App\Library;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Transaction;
use App\Enums\PaymentMethod;

class WalletHandler
{
    /**
     * Payment method of the order
     *
     * @var string
     */
    private $paymentMethod;

    /**
     * Set the payment method
     *
     * @param \App\Enums\PaymentMethod $paymentMethod
     */
    public function __construct($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Charge payment from the gateway
     *
     * @param int    $amount
     * @param string $token
     * @param string $description
     */
    public function charge($amount, $curreny, $token = null, $description)
    {
        if ($this->paymentMethod == PaymentMethod::STRIPE()) {
            $this->chargeFromStripe($amount, $curreny, $token, $description);
        }
    }

    /**
     * Charge for stripe payment gateway
     *
     * @param int    $amount
     * @param string $token
     * @param string $description
     */
    public function chargeFromStripe($amount, $curreny, $token, $description)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        Charge::create([
            "amount"      => $amount * 100,
            "currency"    => $curreny,
            "source"      => $token,
            "description" => $description
        ]);
    }

    /**
     * Create a new order with given data
     *
     * @param int $amount
     * @return \App\Models\Transaction
     */
    public function createTransaction($amount)
    {
        return Transaction::create([
            'customerId'  => auth()->user()->id,
            'amount'      => $amount,
            'method'      => $this->paymentMethod,
            'description' => "Balace added"
        ]);
    }
}