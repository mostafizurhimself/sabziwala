<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Loan;
use Inertia\Inertia;
use App\Models\Salary;
use App\Models\Payslip;
use App\Models\Settings;
use App\Enums\LoanStatus;
use App\Enums\SettingsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PayslipRequest;

class PayslipController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Salary $salary)
    {
        if (!request()->user()->hasPermissionTo('can-pay-salaries')) {
            abort(403);
        }

        $loan = Loan::where('employee_id', $salary->employeeId)->where('status', [LoanStatus::CONFIRMED(), LoanStatus::PARTIAL()])->first();
        // Start from here ...
        return Inertia::render('Payslips/Create', [
            'salary'     => $salary,
            'deductable' => $loan ? $loan->dueAmount : 0
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PayslipRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PayslipRequest $request, Salary $salary)
    {
        if (!request()->user()->hasPermissionTo('can-pay-salaries')) {
            abort(403);
        }

        // Start from here ...
        $payslip = DB::transaction(function () use ($request, $salary) {
            $payslip = $salary->payslips()->create([
                'employeeId'     => $salary->employeeId,
                'paidAmount'     => $request->paidAmount,
                'deductedAmount' => $request->deductedAmount,
            ]);
            $salary->updatePaidAmount();
            $salary->updateTotalDeducted();
            $salary->updateStatus();

            // Update the loan
            $loan = $payslip->employee->loans()->whereIn('status', [LoanStatus::CONFIRMED(), LoanStatus::PARTIAL()])->first();
            if ($loan) {
                $loan->update(['paidAmount' => $payslip->deductedAmount]);
                $loan->updateStatus();
            }

            return $payslip;
        });

        return $payslip;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function show(Payslip $payslip)
    {
        if (!request()->user()->hasPermissionTo('can-pay-salaries')) {
            abort(403);
        }

        // Start from here ...
        return PDF::loadView('payslip', [
            'payslip'  => $payslip->load('salary', 'employee'),
            'settings' => Settings::where('name', SettingsType::WEBSITE())->first() ?? null,
        ])->stream("payslip-{$payslip->salary->month}-({$payslip->employee->id}).pdf");
    }
}