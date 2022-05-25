<?php

namespace App\Http\Controllers\Api;

use App\Facades\Response;
use App\Models\Tag;
use App\Models\Country;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class AjaxController extends Controller
{

    /**
     * Get the available country list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function country()
    {
        return Country::pluck("name")->toArray();
    }

    /**
     * Get the available Product list
     *
     */
    public function category()
    {
        return ApiResource::collection(Category::orderBy("name")->get());
    }

    /**
     * Get the available Tag list
     *
     */
    public function tag()
    {
        return ApiResource::collection(Tag::orderBy("name")->get());
    }

    /**
     * Check customer availablity
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkCustomer(Request $request)
    {
        if (Customer::where("phone", $request->phone)->first()) {
            return Response::success("Customer already exists", ["exists"  => true]);
        }
        return Response::success("Customer doesn't exists", ["exists"  => false]);
    }
}