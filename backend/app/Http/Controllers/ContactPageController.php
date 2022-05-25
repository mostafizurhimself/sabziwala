<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Appearance;
use Illuminate\Http\Request;
use App\Enums\AppearanceType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ContactPageController extends Controller
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

        return Inertia::render('Appearances/Contact/Show', [
            'contactPageHero'   => Appearance::where('name', AppearanceType::CONTACT_PAGE_HERO())->first() ?? null,

        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hero(Request $request)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances'))) {
            abort(403);
        }

        // Start from here ...
        $request->validate([
            'title'    => 'required|string|max:100',
            'poster'   => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        DB::transaction(function () use ($request) {
            $hero = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::CONTACT_PAGE_HERO()
                ],
                [
                    'data' => [
                        'title'    => $request->title,
                    ]
                ]
            );

            if ($request->file('poster')) {
                $hero->addMedia($request->poster)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'Hero Settings Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.contact');
    }

}
