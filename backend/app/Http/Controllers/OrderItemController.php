<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (request()->user()->cannot('viewAny', OrderItem::class)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        if (request()->user()->cannot('create', OrderItem::class)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (request()->user()->cannot('create', OrderItem::class)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(OrderItem $orderItem)
    {
        if (request()->user()->cannot('view', $orderItem)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(OrderItem $orderItem)
    {
        if (request()->user()->cannot('update', $orderItem)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        if (request()->user()->cannot('update', $orderItem)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(OrderItem $orderItem)
    {
        if (request()->user()->cannot('delete', $orderItem)) {
            abort(403);
        }

        // Start from here ...
    }
}
