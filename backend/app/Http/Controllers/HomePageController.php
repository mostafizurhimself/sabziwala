<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Appearance;
use Illuminate\Http\Request;
use App\Enums\AppearanceType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\HowItWorks;

class HomePageController extends Controller
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

        return Inertia::render('Appearances/Home/Show', [
            'hero'        => Appearance::where('name', AppearanceType::HERO())->first() ?? null,
            'howItWorks'  => Appearance::where('name', AppearanceType::HOW_IT_WORKS())->first() ?? null,
            'apps'        => Appearance::where('name', AppearanceType::APP_SECTION())->first() ?? null,
            'howItWorks'  => HowItWorks::all(),
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
                    'name' => AppearanceType::HERO()
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

        session()->flash('flash.banner', 'Hero settings updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.home');
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
                    'name' => AppearanceType::APP_SECTION()
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

        session()->flash('flash.banner', 'Apps settings updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.home');
    }
}
