<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UnitRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UnitRequest $request)
    {
        if (request()->user()->cannot('create', Unit::class)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request) {
            $unit = Unit::create([
                'name' => $request->name,
                'code' => Str::lower($request->code)
            ]);
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('settings.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UnitRequest  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        if (request()->user()->cannot('update', $unit)) {
            abort(403);
        }

        // Start from here ...

        $unit->update([
            'name' => $request->name,
            'code' => Str::lower($request->code)
        ]);

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Unit $unit)
    {
        if (request()->user()->cannot('delete', $unit)) {
            abort(403);
        }

        // Start from here ...
        if ($unit->products()->exists()) {
            session()->flash('flash.banner', "There are {$unit->products()->count()} products related to it. You can not delete it now.");
            session()->flash('flash.bannerStyle', 'danger');
            return;
        }

        if ($unit->orderItems()->exists()) {
            session()->flash('flash.banner', "There are {$unit->orderItems()->count()} orders related to it. You can not delete it now.");
            session()->flash('flash.bannerStyle', 'danger');
            return;
        }

        if ($unit->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
