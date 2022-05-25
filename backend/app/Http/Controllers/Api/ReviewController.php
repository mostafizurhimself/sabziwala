<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('assign.guard:customers')->only('store');
        $this->middleware('jwt.auth')->only('store');
    }

    /**
     * Add review to a product
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderItem    $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, OrderItem $orderItem)
    {
        $this->validate($request, [
            'review' => ['required', 'string', 'max:350'],
            'rating' => ['required', 'numeric']
        ]);

        $customer = Customer::find(auth()->user()->id);
        $product  = Product::find($orderItem->productId);
        $rating = DB::transaction(function () use ($orderItem, $request, $customer, $product) {
            $rating = $product->rating([
                'body' => $request->review,
                'rating' => $request->rating,
                'recommend' => 'Yes',
            ], $customer);

            $orderItem->update(['review_id' => $rating->id]);
            return $rating;
        });

        return new ApiResource($rating);
    }
}
