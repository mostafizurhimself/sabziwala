<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use App\Models\Order;
use App\Facades\Helper;
use App\Facades\Response;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Library\OrderHandler;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class OrderController extends Controller
{

    /**
     * Set the middlewares
     */
    public function __construct()
    {
        $this->middleware('assign.guard:customers')->except('store', 'assignedOrders', 'showAssigned', 'updateAssigned');
        $this->middleware('assign.guard:riders')->only('assignedOrders', 'showAssigned', 'updateAssigned');
        $this->middleware('jwt.auth')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return ApiResource::collection(Order::with('customer')->where('customer_id', auth()->user()->id)->doesntHave('refundRequest')->filter($request->all())->sorted()->paginate(10));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        // return auth()->user();
        // return new ApiResource($order->load('address', 'orderItems', 'customer')->append('billingAddress', 'shippingAddress'));
        if (auth()->user()->id == $order->customerId || auth()->user()->id == $order->riderId) {
            return new ApiResource($order->load('address', 'orderItems', 'customer')->append('billingAddress', 'shippingAddress'));
        } else {
            Response::error('Unauthorized', 403);
        }
    }

    /**
     * Create a new order
     *
     * @param \App\Http\Requests\OrderRequest $request
     * @param \App\Library\OrderHandler       $orderHandler
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderRequest $request, OrderHandler $orderHandler)
    {
        $order = DB::transaction(function () use ($request, $orderHandler) {
            $order = $orderHandler->createOrder($request);
            $orderHandler->charge($request, $order, Helper::getCurrencyCode());
            return $order;
        });


        return new ApiResource($order);
    }

    /**
     * Display assigned orders for rider.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignedOrders(Request $request)
    {
        return ApiResource::collection(Order::where('rider_id', auth()->user()->id)->where('status', OrderStatus::SHIPPED())->doesntHave('refundRequest')->with('customer', 'address')->filter($request->all())->sorted()->paginate(10));
    }


    /**
     * Display delivered orders for rider.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliveredOrders(Request $request)
    {
        return ApiResource::collection(Order::with('customer', 'address')->where('rider_id', auth()->user()->id)->doesntHave('refundRequest')->where('status', OrderStatus::DELIVERED())->filter($request->all())->sorted()->paginate(10));
    }

    /**
     * Display assigned orders for rider.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ridersHome(Request $request)
    {
        $lastWeek = CarbonPeriod::create(Carbon::today()->subDays(6), Carbon::today());
        $periodData = [];
        foreach ($lastWeek as $date) {
            $periodData[$date->format('d M')] = ['assigned' => 0, 'delivered' => 0];
        }
        $today = Carbon::today();
        $lastDate = Carbon::today()->subDays(6);  // returns last 7th date

        $pendingCount = Order::where('rider_id', auth()->user()->id)->where('status', OrderStatus::SHIPPED())->doesntHave('refundRequest')->count();
        $completedCount = Order::where('rider_id', auth()->user()->id)->where('status', OrderStatus::DELIVERED())->doesntHave('refundRequest')->count();

        $ordersStat = Order::where('rider_id', auth()->user()->id)
            ->whereBetween('rider_assign_date', [$lastDate, $today])
            ->get()
            ->groupBy(function ($order) {
                return $order->rider_assign_date->format('d M');
            })
            ->map(function ($orders) {
                $stat = ['assigned' => $orders->count(), 'delivered' => 0];
                foreach ($orders as $order) {
                    if ($order->deliveryDate !== null) {
                        $stat['delivered']++;
                    }
                }
                return $stat;
            })
            ->toArray();

        $lastweekOrdersStat = array_replace($periodData, $ordersStat);
        return ['pendingCount' => $pendingCount, 'completedCount' => $completedCount, 'lastweekOrdersStat' => $lastweekOrdersStat];
    }

    /**
     * Display delivered orders for rider.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function completedOrders(Request $request)
    {
        return ApiResource::collection(Order::with('customer', 'address')->where('rider_id', auth()->user()->id)->doesntHave('refundRequest')->where('status', 'delivered')->filter($request->all())->sorted()->paginate(10));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAssigned(Order $order)
    {
        if (auth()->user()->id == $order->riderId) {
            return new ApiResource($order->load('address', 'orderItems', 'customer')->append('billingAddress', 'shippingAddress'));
        } else {
            Response::error('Unauthorized', 403);
        }
    }

    /**
     * Update the specified order status for rider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAssigned(Request $request, Order $order)
    {
        $this->validate($request, [
            'status' => 'required'
        ]);

        if (auth()->user()->id == $order->riderId) {
            $update = $order->update([
                'status' => $request->status,
                'delivery_date' => Carbon::now()
            ]);
        } else {
            Response::error('Unauthorized', 403);
        }

        if ($update) {
            return Response::success('Order updated successfully');
        }
        return Response::error('Order updated failed');
    }
}
