<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Inertia\Inertia;
use App\Models\Rider;
use App\Enums\ActiveStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RiderRequest;
use App\Http\Controllers\Controller;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Rider::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Riders/Index', [
            'riders' => Rider::with('zone')
                ->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'statusOptions' => ActiveStatus::toSelectOptions(),
            'zones'=> Zone::filterOptions(),
            'query'  => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        if (request()->user()->cannot('create', Rider::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Riders/Create',[
            'zones'      => Zone::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RiderRequest $request)
    {
        if (request()->user()->cannot('create', Rider::class)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request) {
            $rider = Rider::create(array_merge(
                $request->only('zoneId','firstName', 'lastName', 'email', 'phone'),
                ['password' => bcrypt($request->password)]
            ));

            if ($request->hasFile('photo')) {
                $rider->addMedia($request->photo)->toMediaCollection('profile-photo');
            }

            if ($request->hasFile('verificationFront')) {
                $rider->addMedia($request->verificationFront)->toMediaCollection('verification-front');
            }

            if ($request->hasFile('verificationBack')) {
                $rider->addMedia($request->verificationBack)->toMediaCollection('verification-back');
            }
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('riders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rider  $rider
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Rider $rider)
    {
        if (request()->user()->cannot('view', $rider)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Riders/Show', [
            'rider' => $rider->load('zone'),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Rider $rider)
    {
        if (request()->user()->cannot('update', $rider)) {
            abort(403);
        }

        if ($rider->status == ActiveStatus::ACTIVE()) {
            $rider->update(['status' => ActiveStatus::INACTIVE()]);
            session()->flash('flash.banner', 'Rider inactive successful.');
            session()->flash('flash.bannerStyle', 'success');
        } else {
            session()->flash('flash.banner', 'Rider active successful.');
            session()->flash('flash.bannerStyle', 'success');
            $rider->update(['status' => ActiveStatus::ACTIVE()]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function verified(Rider $rider)
    {
        if (request()->user()->cannot('update', $rider)) {
            abort(403);
        }
        if ($rider->verified) {
            $rider->update(['verified' => false]);
            session()->flash('flash.banner', 'Rider unverified successful.');
            session()->flash('flash.bannerStyle', 'success');
        } else {
            session()->flash('flash.banner', 'Rider verified successful.');
            session()->flash('flash.bannerStyle', 'success');
            $rider->update(['verified' => true]);
        }

        return back();
    }
}
