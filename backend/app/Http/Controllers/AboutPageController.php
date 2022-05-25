<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Appearance;
use Illuminate\Http\Request;
use App\Enums\AppearanceType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AboutFaq;
use App\Models\WhyChooseUs;

class AboutPageController extends Controller
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

        return Inertia::render('Appearances/About/Show', [
            'aboutPageHero'       => Appearance::where('name', AppearanceType::ABOUT_PAGE_HERO())->first() ?? null,
            'ownerComment'        => Appearance::where('name', AppearanceType::OWNER_SECTION())->first() ?? null,
            'whyChooseUs'         => Appearance::where('name', AppearanceType::WHY_CHOOSE_US())->first() ?? null,
            'aboutFaqs'           => Appearance::where('name', AppearanceType::ABOUT_FAQ())->first() ?? null,
            'aboutFaqs'           => AboutFaq::all(),
            'whyChooseUs'         => WhyChooseUs::all(),

        ]);

        // Start from here ...
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
                    'name' => AppearanceType::ABOUT_PAGE_HERO()
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

        return redirect()->route('appearance.about');
    }


        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function owner(Request $request)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances'))) {
            abort(403);
        }

        // Start from here ...
        $request->validate([
            'title'          => 'required|string|max:100',
            'subtitle'       => 'required|string|max:200',
            'description'    => 'required|string|max:500',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        DB::transaction(function () use ($request) {
            $hero = Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::OWNER_SECTION()
                ],
                [
                    'data' => [
                        'title'         => $request->title,
                        'subtitle'      => $request->subtitle,
                        'description'   => $request->description,
                    ]
                ]
            );

            if ($request->file('image')) {
                $hero->addMedia($request->image)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'Hero Settings Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.about');
    }


}
