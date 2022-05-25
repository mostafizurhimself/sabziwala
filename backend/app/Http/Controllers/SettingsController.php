<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Country;
use App\Models\Settings;
use App\Enums\SettingsType;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Unit;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (request()->user()->cannot('viewAny', Settings::class)) {
            abort(403);
        }

        // Start from here ...

        {
            return Inertia::render('Settings/Show', [
                'website'  => Settings::where('name', SettingsType::WEBSITE())->first() ?? null,
                'currency' => Settings::where('name', SettingsType::CURRENCY())->first() ?? null,
                'countries' => Country::all(),
                'units' => Unit::all(),

            ]);
        }
    }


    /**
     *Save  website settings details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\JsonResponse
     */
    public function website(Request $request, Settings $settings)
    {
        if (request()->user()->cannot('update', $settings)) {
            abort(403);
        }

        // Start from here ...

        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'required|string|max:100',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png|max:5000',
            'phone'       => 'required|string|max:200',
            'email'       => 'required|email',
            'street'      => 'required|string|max:200',
            'city'        => 'required|string|max:100',
            'zip'         => 'required|string|max:10',
            'country'     => 'required|string|max:50',
            'facebook'    => 'nullable|string',
            'twitter'     => 'nullable|string',
            'instagram'   => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $website = Settings::updateOrCreate(
                [
                    'name' => SettingsType::WEBSITE()
                ],
                [
                    'data' => [
                        'name'        => $request->name,
                        'description' => $request->description,
                        'phone'       => $request->phone,
                        'email'       => $request->email,
                        'street'      => $request->street,
                        'city'        => $request->city,
                        'zip'         => $request->zip,
                        'country'     => $request->country,
                        'facebook'    => $request->facebook,
                        'twitter'     => $request->twitter,
                        'instagram'   => $request->instagram,
                    ]
                ]
            );

            if ($request->file('logo')) {
                $website->addMedia($request->logo)->toMediaCollection('primary');
            }
        });

        session()->flash('flash.banner', 'Website settings updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('settings.index');
    }

    /**
     *Save  currency settings details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\JsonResponse
     */
    public function currency(Request $request, Settings $settings)
    {
        if (request()->user()->cannot('update', $settings)) {
            abort(403);
        }

        // Start from here ...

        $request->validate([
            'name'        => 'required|string|max:100',
            'code'        => 'required|string|max:04',
            'symbol'      => 'required|string|max:03',
        ]);

        DB::transaction(function () use ($request) {
            Settings::updateOrCreate(
                [
                    'name' => SettingsType::CURRENCY()
                ],
                [
                    'data' => [
                        'name'        => $request->name,
                        'code'        => $request->code,
                        'symbol'      => $request->symbol,
                    ]
                ]
            );
        });

        session()->flash('flash.banner', 'Currency settings updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('settings.index');
    }
}
