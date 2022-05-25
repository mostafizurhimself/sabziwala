<?php

namespace App\Http\Controllers;

use App\Models\Appearance;
use App\Models\HowItWorks;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HowItWorksController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('create-appearances') )) {
            abort(403);
        }

        // Start from here ...
            $request->validate([
                'title'         => 'required|string|max:100',
                'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            ]);

            DB::transaction(function () use ($request) {
                $howItWorks = HowItWorks::create(
                    [
                        'title'       => $request->title,
                    ]
                );

                if ($request->file('image')) {
                    $howItWorks->addMedia($request->image)->toMediaCollection('primary');
                }
            });

            session()->flash('flash.banner', 'How it works added successfully.');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('appearance.home');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HowItWorks  $howItWorks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HowItWorks $howItWorks)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances') )) {
            abort(403);
        }
        // Start from here ...

        $request->validate([
            'title'       => 'required|string|max:100',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
        ]);

        DB::transaction(function () use ($request, $howItWorks) {
            $howItWorks->update(
                [
                    'title'       => $request->title,
                ]
            );

            if ($request->file('image')) {
                $howItWorks->addMedia($request->image)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'How it works updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HowItWorks  $howItWorks
     * @return \Illuminate\Http\Response
     */
    public function destroy(HowItWorks $howItWorks)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('delete-appearances') )) {
            abort(403);
        }

        // Start from here ...
        if ($howItWorks->delete()) {
            session()->flash('flash.banner', 'How it works deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
