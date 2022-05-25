<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Zone;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Rider;
use App\Models\Customer;
use App\Models\Settings;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use App\Enums\SettingsType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Order::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Orders/Index', [
            'orders' => Order::with('customer', 'rider', 'zone')->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'zones'          => Zone::filterOptions(),
            'customers'      => Customer::filterOptions(),
            'riders'         => Rider::filterOptions(),
            'query'          => $request->all(),
            'statusOptions'  => OrderStatus::toSelectOptions(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Order $order)
    {
        if (request()->user()->cannot('view', $order)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Orders/Show', [
            'order' => $order->load('address', 'customer', 'rider')->append('billingAddress', 'shippingAddress'),
            'statusOptions'  => OrderStatus::toSelectOptions([OrderStatus::REFUNDED()]),
            'orderItems'     => OrderItem::where('order_id', $order->id)
                ->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'riders' => Rider::orderBy('id', 'desc')->get()

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function invoice(Order $order)
    {
        if (request()->user()->cannot('view', $order)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Orders/InvoicePage', [
            'order' => $order->load('orderItems', 'address', 'customer')->append('billingAddress', 'shippingAddress'),
            'website'  => Settings::where('name', SettingsType::WEBSITE())->first() ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Order $order)
    {
        if (request()->user()->cannot('update', $order)) {
            abort(403);
        }

        // Start from here ...
        $this->validate($request, [
            'status' => 'required'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        session()->flash('flash.banner', 'Status updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        if (!$request->user()->hasPermissionTo('update-orders')) {
            abort(403);
        }

        // Start from here ...
        $this->validate($request, [
            'status' => 'required',
            'ids'    => 'array'
        ]);

        Order::whereIn('id', $request->ids)->update(['status' => $request->status]);

        session()->flash('flash.banner', 'Status updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignRider(Request $request)
    {
        if (!$request->user()->hasPermissionTo('update-orders')) {
            abort(403);
        }

        // dd($request->ids);

        // Start from here ...
        $this->validate($request, [
            'ids'     => 'required',
            'riderId' => 'required',

        ]);

        Order::whereIn('id', $request->ids)->update(['rider_id' => $request->riderId, 'rider_assign_date' => Carbon::now(), 'status' => OrderStatus::SHIPPED()]);


        session()->flash('flash.banner', 'Rider assigned successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }
}
