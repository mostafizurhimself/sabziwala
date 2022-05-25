<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Inertia\Inertia;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\ZoneRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Zone::class)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Zones/Index', [
            'zones' => Zone::filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'query'     => $request->all(),
            'countries' => Country::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        if (request()->user()->cannot('create', Zone::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Zones/Create', [
            'countries' => Country::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ZoneRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ZoneRequest $request)
    {
        if (request()->user()->cannot('create', Zone::class)) {
            abort(403);
        }

        // Start from here ...
        Zone::create($request->only('name', 'city', 'state', 'zipcode', 'country'));

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('zones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Zone $zone)
    {
        if (request()->user()->cannot('view', $zone)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Zones/Show', [
            'zone' => $zone
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Zone $zone)
    {
        if (request()->user()->cannot('update', $zone)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Zones/Edit', [
            'zone'      => $zone,
            'countries' => Country::orderBy('name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ZoneRequest  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ZoneRequest $request, Zone $zone)
    {
        if (request()->user()->cannot('update', $zone)) {
            abort(403);
        }

        // Start from here ...
        $zone->update($request->only('name', 'city', 'state', 'zipcode', 'country'));

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('zones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Zone $zone)
    {
        if (request()->user()->cannot('delete', $zone)) {
            abort(403);
        }

        // Start from here ...
        if ($zone->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');

            return back()->with('status', 'Deleted successfully.');
        }
    }
}
