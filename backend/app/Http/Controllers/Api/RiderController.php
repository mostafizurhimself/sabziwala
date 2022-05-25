<?php

namespace App\Http\Controllers\Api;

use App\Models\Rider;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return ApiResource::collection(Rider::verified()->filter($request->all())->orderBy('id', 'desc')->paginate(10));
    }
}
