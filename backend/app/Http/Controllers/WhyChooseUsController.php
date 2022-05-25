<?php

namespace App\Http\Controllers;

use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WhyChooseUsController extends Controller
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
                'description'   => 'required|string|max:500',
                'icon'          => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            ]);

            DB::transaction(function () use ($request) {
                $workWithUs = WhyChooseUs::create(
                    [
                        'title'       => $request->title,
                        'description' => $request->description,
                    ]
                );

                if ($request->file('icon')) {
                    $workWithUs->addMedia($request->icon)->toMediaCollection('primary');
                }
            });

            session()->flash('flash.banner', 'Why choose us added successfully.');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('appearance.about');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WhyChooseUs  $whyChooseUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WhyChooseUs $whyChooseUs)
    {

        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances') )) {
            abort(403);
        }
        // Start from here ...

        $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
        ]);

        DB::transaction(function () use ($request, $whyChooseUs) {
            $whyChooseUs->update(
                [
                    'title'       => $request->title,
                    'description' => $request->description,
                ]
            );

            if ($request->file('icon')) {
                $whyChooseUs->addMedia($request->icon)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'Why choose us updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WhyChooseUs  $whyChooseUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(WhyChooseUs $whyChooseUs)
    {

        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('delete-appearances') )) {
            abort(403);
        }

        // Start from here ...
        if ($whyChooseUs->delete()) {
            session()->flash('flash.banner', 'Why choose us delete successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();

    }
}
