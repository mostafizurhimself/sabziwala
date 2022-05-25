<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Inertia\Inertia;
use App\Models\Employee;
use App\Enums\LoanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Loan::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Loans/Index', [
            'loans' => Loan::with('employee')
            ->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'status'    =>LoanStatus::toSelectOptions(),
            'query'  => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->user()->cannot('create', Loan::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Loans/Create',[
            'employees' => Employee::all()->sortBy('name')->values()->all(),
            'status'    => LoanStatus::toSelectOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanRequest $request)
    {
        if (request()->user()->cannot('create', Loan::class)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request) {
             Loan::create($request->only('employeeId', 'loanDate', 'loanAmount', 'paidAmount', 'status'));
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('loans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        if (request()->user()->cannot('view', $loan)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Loans/Show',[
            'loan'=> $loan->load('employee')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
         if (request()->user()->cannot('update', $loan)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Loans/Edit',[
            'employees' => Employee::all()->sortBy('name')->values()->all(),
            'status'    =>LoanStatus::toSelectOptions(),
            'loan' => $loan->load('employee'),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
         if (request()->user()->cannot('update', $loan)) {
            abort(403);
        }
        // Start from here ...

        DB::transaction(function () use ($request, $loan) {
            $loan->update($request->only('employeeId', 'loanDate', 'loanAmount', 'paidAmount', 'status'));
        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('loans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
         if (request()->user()->cannot('delete', $loan)) {
            abort(403);
        }

        // Start from here ...
        if ($loan->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Loan  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmed(Loan $loan)
    {
        if (!request()->user()->hasPermissionTo('can-confirm-loans')) {
            abort(403);
        }

        if ($loan->status == LoanStatus::DRAFT()) {
            $loan->update(['status' => LoanStatus::CONFIRMED()]);
            session()->flash('flash.banner', 'Loan Confirmed successful.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }


        /**
     * Confirm the selected loans
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmMultiple(Request $request)
    {
        if (!$request->user()->hasPermissionTo('update-loans')) {
            abort(403);
        }

        // Start from here ...
        $this->validate($request, [
            'ids'    => 'array'
        ]);
        $loans = Loan::whereIn('id', $request->ids)->get();

        foreach ($loans as $loan) {
            if ($loan->status == LoanStatus::DRAFT()) {
                $loan->update(['status' => LoanStatus::CONFIRMED()]);
            }
        }

        session()->flash('flash.banner', 'Confirmed successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }
}
