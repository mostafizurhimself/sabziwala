<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseTypeRequest;
use Illuminate\Support\Facades\DB;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', ExpenseType::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('ExpenseType/Index', [
            'expenseTypes' => ExpenseType::filter($request->all())
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
        if (request()->user()->cannot('create', ExpenseType::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('ExpenseType/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseTypeRequest $request)
    {
        if (request()->user()->cannot('create', ExpenseType::class)) {
            abort(403);
        }

        // Start from here ...
        DB::transaction(function () use ($request) {
            ExpenseType::create($request->only('name', 'description'));
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('expense-type.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseType $expenseType)
    {
        if (request()->user()->cannot('update', $expenseType)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('ExpenseType/Edit', [
            'expenseType' => $expenseType
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseType $expenseType)
    {
        if (request()->user()->cannot('update', $expenseType)) {
            abort(403);
        }

        // Start from here ...

        $expenseType->update($request->only('name', 'description'));

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('expense-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseType $expenseType)
    {
        if (request()->user()->cannot('delete', $expenseType)) {
            abort(403);
        }
        // Start from here ...
        if ($expenseType->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
