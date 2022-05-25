<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return ProductResource::collection(Product::with(['tags', 'unit', 'category', 'zone', 'ratings'])->withCount('ratings')->filter($request->all())->sorted()->paginate(10));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Product $product)
    {
        $relatedProducts = Product::whereHas('tags', function ($tag) use ($product) {
            $tag->whereIn('id', $product->tags()->pluck('id')->toArray());
        })
            ->where('category_id', $product->categoryId)
            ->where('zone_id', $product->zoneId)
            ->limit(5)
            ->get();

        return (new ProductResource($product->load('tags', 'unit', 'category', 'zone', 'ratings.author')->append('isFavorited')))
            ->additional(['relatedProducts' => $relatedProducts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function showForAuth(Request $request, Product $product)
    {
        $relatedProducts = Product::whereHas('tags', function ($tag) use ($product) {
            $tag->whereIn('id', $product->tags()->pluck('id')->toArray());
        })
            ->where('category_id', $product->categoryId)
            ->where('zone_id', $product->zoneId)
            ->limit(5)
            ->get();

        return (new ProductResource($product->load('tags', 'unit', 'category', 'zone', 'ratings.author')->append('isFavorited')))
            ->additional(['relatedProducts' => $relatedProducts]);
    }
}