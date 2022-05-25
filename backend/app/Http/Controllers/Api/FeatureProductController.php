<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class FeatureProductController extends Controller
{
           /**
     *  Get all Feature Product
     *
     * @param \App\Models\Product      $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        return ApiResource::collection(Product::withCount('orderItems')->where([
            'zone_id'     => $request->zone,
            'is_featured' => true
        ])->orderBy('order_items_count', 'desc')->take(6)->get());
    }
}
