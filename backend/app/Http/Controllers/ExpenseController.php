<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Expense;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Expense::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Expenses/Index', [
            'expenses' => Expense::with('expenseType')
                ->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
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
        if (request()->user()->cannot('create', Expense::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Expenses/Create', [
            'expenseTypes' => ExpenseType::orderBy('name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        if (request()->user()->cannot('create', Expense::class)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request) {
            Expense::create($request->only('expenseTypeId',  'description', 'amount'));
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('expenses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        if (request()->user()->cannot('view', $expense)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        if (request()->user()->cannot('update', $expense)) {
            abort(403);
        }

        // Start from here ...


        return Inertia::render('Expenses/Edit', [
            'expense' => $expense->load('expenseType'),
            'expenseTypes' => ExpenseType::orderBy('name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        if (request()->user()->cannot('update', $expense)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request, $expense) {
            $expense->update($request->only('expenseTypeId',  'description', 'amount'));
        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        if (request()->user()->cannot('delete', $expense)) {
            abort(403);
        }

        // Start from here ...
        // Start from here ...
        if ($expense->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
