<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Appearance;
use Illuminate\Http\Request;
use App\Enums\AppearanceType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TermsPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('view-any-appearances'))) {
            abort(403);
        }
        // Start from here ...
        return Inertia::render('Appearances/Terms/Show', [
            'terms'        => Appearance::where('name', AppearanceType::TERMS_CONDITIONS())->first() ?? null,
        ]);


    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function termsConditions(Request $request)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances'))) {
            abort(403);
        }

        // Start from here ...
        $request->validate([
            'general'    => 'required|string',
            'privacy'    => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
             Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::TERMS_CONDITIONS()
                ],
                [
                    'data' => [
                        'general'    => $request->general,
                        'privacy'    => $request->privacy,

                    ]
                ]
            );
        });

        session()->flash('flash.banner', 'Terms Settings Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.terms');
    }
}
