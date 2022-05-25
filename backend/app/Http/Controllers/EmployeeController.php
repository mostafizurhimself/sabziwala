<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Inertia\Inertia;
use App\Models\Employee;
use App\Enums\BloodGroup;
use App\Enums\GenderType;
use App\Enums\MaritalStatus;
use Illuminate\Http\Request;
use App\Enums\EmployeeStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->cannot('viewAny', Employee::class)) {
            abort(403);
        }

            // Start from here ...
            return Inertia::render('Employees/Index', [
                'employees' => Employee::with('zone')
                ->filter($request->all())
                    ->sorted()
                    ->paginate()
                    ->withQueryString(),
                'status'=> EmployeeStatus::toSelectOptions(),
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
        if (request()->user()->cannot('create', Employee::class)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Employees/Create',[
            'gender'       => GenderType::toSelectOptions(),
            'maritalStatus'=> MaritalStatus::toSelectOptions(),
            'bloodGroup'   => BloodGroup::toSelectOptions(),
            'status'       => EmployeeStatus::toSelectOptions(),
            'zones'        => Zone::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        // return $request->all();
        if (request()->user()->cannot('create', Employee::class)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request) {
            $employee = Employee::create($request->only('zoneId','firstName', 'lastName', 'email', 'phone', 'fatherName', 'motherName', 'gender', 'maritalStatus','bloodGroup','designation','joiningDate','resignDate', 'salary', 'status'));

            if ($request->hasFile('photo')) {
                $employee->addMedia($request->photo)->toMediaCollection('profile-photo');
            }
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        if (request()->user()->cannot('view', $employee)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Employees/Show',[
            'employee'=> $employee->load('zone')
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
         if (request()->user()->cannot('update', $employee)) {
            abort(403);
        }

        // Start from here ...
        return Inertia::render('Employees/Edit',[
            'employee' => $employee,
            'gender'       => GenderType::toSelectOptions(),
            'maritalStatus'=> MaritalStatus::toSelectOptions(),
            'bloodGroup'   => BloodGroup::toSelectOptions(),
            'status'       => EmployeeStatus::toSelectOptions(),
            'zones'         => Zone::all(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
         if (request()->user()->cannot('update', $employee)) {
            abort(403);
        }

        // Start from here ...

        DB::transaction(function () use ($request, $employee) {

            $employee->update($request->only('zoneId','firstName', 'lastName', 'email', 'phone', 'fatherName', 'motherName', 'gender', 'maritalStatus','bloodGroup','designation','joiningDate','resignDate', 'salary', 'status'));

            if ($request->hasFile('photo')) {
                $employee->addMedia($request->photo)->toMediaCollection('profile-photo');
            }

        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
         if (request()->user()->cannot('delete', $employee)) {
            abort(403);
        }

        // Start from here ...

        if ($employee->delete()) {
            session()->flash('flash.banner', 'Deleted successfully.');
            session()->flash('flash.bannerStyle', 'success');
        }

        return back();
    }
}
