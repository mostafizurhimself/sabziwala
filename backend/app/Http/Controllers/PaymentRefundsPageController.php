<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Appearance;
use Illuminate\Http\Request;
use App\Enums\AppearanceType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PaymentRefundsPageController extends Controller
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
        return Inertia::render('Appearances/PaymentRefunds/Show', [
            'paymentRefunds'        => Appearance::where('name', AppearanceType::PAYMENT_REFUNDS())->first() ?? null,
        ]);

    }

         /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentRefunds(Request $request)
    {
        if (!(request()->user()->isSuperAdmin() || request()->user()->hasPermissionTo('update-appearances'))) {
            abort(403);
        }

        // Start from here ...
        $request->validate([
            'purchase'    => 'required|string',
            'refunds'     => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
             Appearance::updateOrCreate(
                [
                    'name' => AppearanceType::PAYMENT_REFUNDS()
                ],
                [
                    'data' => [
                        'purchase'    => $request->purchase,
                        'refunds'     => $request->refunds,

                    ]
                ]
            );
        });

        session()->flash('flash.banner', 'Payment & Refund Settings Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('appearance.payments');
    }

}
