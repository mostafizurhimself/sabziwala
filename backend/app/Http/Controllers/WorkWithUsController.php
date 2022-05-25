<?php

namespace App\Http\Controllers;

use App\Models\WorkWithUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WorkWithUsController extends Controller
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
                $workWithUs = WorkWithUs::create(
                    [
                        'title'       => $request->title,
                    ]
                );

                if ($request->file('image')) {
                    $workWithUs->addMedia($request->image)->toMediaCollection('primary');
                }
            });

            session()->flash('flash.banner', 'Work with us added successfully.');
            session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('appearance.rider');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkWithUs  $workWithUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkWithUs $workWithUs)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances') )) {
            abort(403);
        }
        // Start from here ...

        $request->validate([
            'title'       => 'required|string|max:100',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
        ]);

        DB::transaction(function () use ($request, $workWithUs) {
            $workWithUs->update(
                [
                    'title'       => $request->title,
                ]
            );

            if ($request->file('image')) {
                $workWithUs->addMedia($request->image)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'Work with us updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkWithUs  $workWithUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkWithUs $workWithUs)
    {

        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('delete-appearances') )) {
            abort(403);
        }

        // Start from here ...
        if ($workWithUs->delete()) {
            session()->flash('flash.banner', 'Work with us delete successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
