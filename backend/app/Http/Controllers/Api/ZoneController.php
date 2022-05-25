<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Zone;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->perPage) {
            return ApiResource::collection(Zone::filter($request->all())->orderBy('name', 'asc')->paginate($request->perPage));
        }
        return ApiResource::collection(Zone::filter($request->all())->orderBy('name', 'asc')->get());
    }
}