<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Inertia\Inertia;
use App\Models\Rider;
use App\Models\Salary;
use App\Models\Payslip;
use App\Models\Employee;
use App\Enums\SalaryType;
use App\Enums\SalaryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Salary::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Salaries/Index', [
            'salaries' => Salary::with('employee', 'zone')
                ->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString(),
            'status'    => SalaryStatus::toSelectOptions(),
            'zones'=> Zone::filterOptions(),
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
        if (request()->user()->cannot('create', Salary::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Salaries/Create', [
            'status'    => SalaryStatus::toSelectOptions(),
            'employees' => Employee::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryRequest $request)
    {
        if (request()->user()->cannot('create', Salary::class)) {
            abort(403);
        }

        // Start from here ...
        DB::transaction(function () use ($request) {
            Salary::create([
                'employeeId'  => $request->employeeId,
                'zoneId'      => Employee::find($request->employeeId)->zoneId,
                'month'       => $request->month,
                'totalAmount' => $request->totalAmount,
            ]);
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('salaries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Salary $salary)
    {
        if (request()->user()->cannot('view', $salary)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Salaries/Show', [
            'salary'     => $salary->load('employee'),
            'payslips'   => $salary->payslips()
                ->filter($request->all())
                ->sorted()
                ->paginate()
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        if (request()->user()->cannot('update', $salary)) {
            abort(403);
        }

        // Start from here ...

        return Inertia::render('Salaries/Edit', [
            'employees' => Employee::all()->sortBy('name')->values()->all(),
            'status'    => SalaryStatus::toSelectOptions(),
            'salary'    => $salary->load('employee'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $salary)
    {
        if (request()->user()->cannot('update', $salary)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request, $salary) {
            $salary->update([
                'employeeId'  => $request->employeeId,
                'zoneId'      => Employee::find($request->employeeId)->zoneId,
                'month'       => $request->month,
                'totalAmount' => $request->totalAmount,
            ]);
        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('salaries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        if (request()->user()->cannot('delete', $salary)) {
            abort(403);
        }

        // Start from here ...
        if ($salary->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }


    /**
     * Confirm the selected salaries
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm(Request $request)
    {
        if (!$request->user()->hasPermissionTo('update-salaries')) {
            abort(403);
        }

        // Start from here ...
        $this->validate($request, [
            'ids'    => 'array'
        ]);
        $salaries = Salary::whereIn('id', $request->ids)->get();

        foreach ($salaries as $salary) {
            if ($salary->status == SalaryStatus::DRAFT()) {
                $salary->update(['status' => SalaryStatus::CONFIRMED()]);
            }
        }

        session()->flash('flash.banner', 'Confirmed successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }

    /**
     * generate a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateSalaries(Request $request)
    {
        $count = 0;
        $employees = Employee::all();
        foreach ($employees as $key => $employee) {
            $newSalary = $employee->salaries()->firstOrNew([
                'zone_id'      => $employee->zoneId,
                'month'        => $request->month,
                'total_amount' => $employee->salary,
            ]);

            // check if salary already created.
            if (!$newSalary->exists) {
                $count++;
                $newSalary->save();
            }
        }

        if ($count && $count > 1) {
            session()->flash('flash.banner', "There are {$count} new salaries generated.");
        } elseif ($count && $count == 1) {
            session()->flash('flash.banner', "There is {$count} new salaries generated.");
        } else {
            session()->flash('flash.banner', "Salaries are already generated");
        }

        session()->flash('flash.bannerStyle', $count ? 'success' : 'danger');
        return redirect()->route('salaries.index');
    }
}
