<?php

namespace App\Library;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Order;
use App\Facades\Helper;
use App\Models\Customer;
use App\Enums\AddressType;
use App\Enums\PaymentMethod;
use App\Models\Transaction;

class OrderHandler
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
     * @param string $currency
     * @param string $token
     * @param string $description
     * @param int    $orderId
     */
    public function charge($request, $order, $currency)
    {
        if ($this->paymentMethod == PaymentMethod::STRIPE()) {
            $this->chargeFromStripe($order->grandTotal, $currency, $request->token, "Order {$order->id} from sabziwala");
        }

        if ($this->paymentMethod == PaymentMethod::WALLET()) {
            $this->chargeFromWallet($request, $order);
        }
    }

    /**
     * Charge for stripe payment gateway
     *
     * @param int    $amount
     * @param string $currency
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
     * Charge charge from the wallet
     *
     * @param int  $amount
     * @param int  $orderId
     */
    public function chargeFromWallet($request, $order)
    {
        $customer = Customer::find($request->customerId);
        $customer->decrement('balance', $order->grandTotal);
        Transaction::create([
            'customerId'  => $customer->id,
            'orderId'     => $order->id,
            'amount'      => -$order->grandTotal,
            'method'      => PaymentMethod::WALLET(),
            'description' => "Payment for {$order->invoiceNo}"
        ]);
    }

    /**
     * Create a new order with given data
     *
     * @param \App\Http\Requests\OrderRequest $request
     * @return \App\Models\Order
     */
    public function createOrder($request)
    {
        $customerId = $request->customerId ?? $this->createCustomer($request);

        $order = Order::create([
            'zoneId'             => $request->zoneId,
            'customerId'         => $customerId,
            'subTotal'           => $request->subTotal,
            'totalDiscount'      => $request->totalDiscount,
            'grandTotal'         => $request->subTotal - $request->totalDiscount,
            'note'               => $request->note,
            'paymentMethod'      => $this->paymentMethod
        ]);

        foreach ($request->orderItems as $item) {
            $order->orderItems()->create(
                [
                    'productId'        => $item['productId'],
                    'rate'             => $item['rate'],
                    'unitId'           => $item['unitId'],
                    'quantity'         => $item['quantity'],
                    'amount'           => $item['amount'],
                ]
            );
        }

        // Set present address
        if (!empty($request->billingAddress)) {
            $order->address()->create(
                [
                    'type'      => AddressType::BILLING_ADDRESS(),
                    'street'    => $request->billingAddress['street'],
                    'city'      => $request->billingAddress['city'],
                    'state'     => $request->billingAddress['state'],
                    'zipcode'   => $request->billingAddress['zipcode'],
                    'country'   => $request->billingAddress['country'],
                ]
            );
        }

        // Set shipping address
        if (!empty($request->shippingAddress)) {
            $order->address()->create(
                [
                    'type'      => AddressType::SHIPPING_ADDRESS(),
                    'street'    => $request->shippingAddress['street'],
                    'city'      => $request->shippingAddress['city'],
                    'state'     => $request->shippingAddress['state'],
                    'zipcode'   => $request->shippingAddress['zipcode'],
                    'country'   => $request->shippingAddress['country'],
                ]
            );
        }

        return $order;
    }

    /**
     * Create a new customer for the order
     *
     * @param \App\Http\Requests\OrderRequest $request
     * @return \App\Models\Customer
     */
    public function createCustomer($request)
    {
        $customer = Customer::create(array_merge(
            $request->only('firstName', 'lastName', 'email', 'phone'),
            ['password' => bcrypt($request->password)]
        ));

        // Set present address
        if (!empty($request->billingAddress)) {
            $customer->address()->create(
                [
                    'type'      => AddressType::BILLING_ADDRESS(),
                    'street'    => $request->billingAddress['street'],
                    'city'      => $request->billingAddress['city'],
                    'state'     => $request->billingAddress['state'],
                    'zipcode'   => $request->billingAddress['zipcode'],
                    'country'   => $request->billingAddress['country'],
                ]
            );
        }

        // Set shipping address
        if (!empty($request->shippingAddress)) {
            $customer->address()->create(
                [
                    'type'      => AddressType::SHIPPING_ADDRESS(),
                    'street'    => $request->shippingAddress['street'],
                    'city'      => $request->shippingAddress['city'],
                    'state'     => $request->shippingAddress['state'],
                    'zipcode'   => $request->shippingAddress['zipcode'],
                    'country'   => $request->shippingAddress['country'],
                ]
            );
        }

        return $customer->id;
    }
}
