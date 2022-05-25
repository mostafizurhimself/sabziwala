<?php

namespace App\Http\Controllers;

use App\Models\AboutFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AboutFaqController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('create-appearances'))) {
            abort(403);
        }

        // Start from here ...
        $request->validate([
            'title'         => 'required|string|max:100',
            'value'         => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($request) {
            AboutFaq::create(
                [
                    'title'       => $request->title,
                    'value'       => $request->value,
                ]
            );
        });

        session()->flash('flash.banner', ' Faq added successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.about');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AboutFaq  $aboutFaq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AboutFaq $aboutFaq)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances'))) {
            abort(403);
        }
        // Start from here ...

        $request->validate([
            'title'         => 'required|string|max:100',
            'value'         => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($request, $aboutFaq) {
            $aboutFaq->update(
                [
                    'title'       => $request->title,
                    'value'       => $request->value,
                ]
            );
        });

        session()->flash('flash.banner', ' Faq updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AboutFaq  $aboutFaq
     * @return \Illuminate\Http\Response
     */
    public function destroy(AboutFaq $aboutFaq)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('delete-appearances'))) {
            abort(403);
        }

        // Start from here ...
        if ($aboutFaq->delete()) {
            session()->flash('flash.banner', ' Faq deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
