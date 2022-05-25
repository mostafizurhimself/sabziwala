<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use App\Enums\ActiveStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Customer::class)) {
            abort(403);
        }
        return Inertia::render('Customers/Index', [
            'customers' => Customer::filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'statusOptions' => ActiveStatus::toSelectOptions(),
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
        if (request()->user()->cannot('create', Customer::class)) {
            abort(403);
        }
        return Inertia::render('Customers/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomerRequest $request)
    {
        if (request()->user()->cannot('create', Customer::class)) {
            abort(403);
        }

        DB::transaction(function () use ($request) {
            $customer = Customer::create(array_merge(
                $request->only('firstName', 'lastName', 'email', 'phone'),
                ['password' => bcrypt($request->password)]
            ));

            $customer->addMedia($request->photo)->toMediaCollection('profile-photo');
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer, Request $request)
    {
        if (request()->user()->cannot('view', $customer)) {
            abort(403);
        }

        return Inertia::render('Customers/Show', [
            'customer'      => $customer->load('address')->append('billingAddress', 'shippingAddress'),
            'transactions'  => $customer->transactions()->with('order')->paginate(5),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Customer $customer)
    {
        if (request()->user()->cannot('update', $customer)) {
            abort(403);
        }

        if ($customer->status == ActiveStatus::ACTIVE()) {
            $customer->update(['status' => ActiveStatus::INACTIVE()]);
            session()->flash('flash.banner', 'Customer inactive successful.');
            session()->flash('flash.bannerStyle', 'success');
        } else {
            session()->flash('flash.banner', 'Customer active successful.');
            session()->flash('flash.bannerStyle', 'success');
            $customer->update(['status' => ActiveStatus::ACTIVE()]);
        }

        return back();
    }
}
