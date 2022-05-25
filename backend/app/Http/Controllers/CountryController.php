<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;

class CountryController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CountryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CountryRequest $request)
    {
        if (request()->user()->cannot('create', Country::class)) {
            abort(403);
        }

        // Start from here ...
        DB::transaction(function () use ($request) {
            $country = Country::create([
                'name' => $request->name,
                'code' => Str::upper($request->code)
            ]);
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('settings.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CountryRequest  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CountryRequest $request, Country $country)
    {
        if (request()->user()->cannot('update', $country)) {
            abort(403);
        }

        // Start from here ...
        $country->update([
            'name' => $request->name,
            'code' => Str::upper($request->code)
        ]);

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Country $country)
    {
        if (request()->user()->cannot('delete', $country)) {
            abort(403);
        }

        // Start from here ...
        if ($country->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
