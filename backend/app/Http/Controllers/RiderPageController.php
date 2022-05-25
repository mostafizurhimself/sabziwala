<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Appearance;
use Illuminate\Http\Request;
use App\Enums\AppearanceType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\RiderFaq;
use App\Models\WorkWithUs;

class RiderPageController extends Controller
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
        return Inertia::render('Appearances/Rider/Show', [
            'riderHero'        => Appearance::where('name', AppearanceType::RIDER_HERO())->first() ?? null,
            'workWithUs'       => Appearance::where('name', AppearanceType::WORK_WITH_US())->first() ?? null,
            'riderApps'        => Appearance::where('name', AppearanceType::RIDER_APPS())->first() ?? null,
            'riderFaqs'        => Appearance::where('name', AppearanceType::RIDER_FAQ())->first() ?? null,
            'workWithUs'       => WorkWithUs::all(),
            'riderFaqs'        => RiderFaq::all(),
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
            'subtitle' => 'required|string|max:200',
            'poster'   => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        DB::transaction(function () use ($request) {
            $hero = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::RIDER_HERO()
                ],
                [
                    'data' => [
                        'title'    => $request->title,
                        'subtitle' => $request->subtitle,
                    ]
                ]
            );

            if ($request->file('poster')) {
                $hero->addMedia($request->poster)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'Hero Settings Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.rider');
    }

       /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apps(Request $request)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances'))) {
            abort(403);
        }

        // Start from here ...
        $request->validate([
            'title'     => 'required|string|max:100',
            'subtitle'  => 'required|string|max:200',
            'playStore' => 'required|string|max:100',
            'appStore'  => 'required|string|max:100',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:10240',

        ]);

        DB::transaction(function () use ($request) {
            $apps = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::RIDER_APPS()
                ],
                [
                    'data' => [

                        'title'     => $request->title,
                        'subtitle'  => $request->subtitle,
                        'playStore' => $request->playStore,
                        'appStore'  => $request->appStore,
                    ]
                ]
            );

            if ($request->file('image')) {
                $apps->addMedia($request->image)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'Apps Settings Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.rider');
    }
}
