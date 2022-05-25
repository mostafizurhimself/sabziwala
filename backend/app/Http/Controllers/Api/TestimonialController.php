<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    /**
     *  Get a Latest 5 star reviews
     *
     * @param \App\Models\Rating      $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        return ApiResource::collection(Review::with('author', 'reviewrateable')->where([
            'approved' => true,
            'rating' => 5
        ])->latest()->take(5)->get());
    }
}
