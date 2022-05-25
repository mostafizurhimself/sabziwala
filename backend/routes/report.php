<?php

use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\EmployeeReportController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\LoanReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderReportController;
use App\Http\Controllers\RiderReportController;
use App\Http\Controllers\SalaryReportController;
use App\Http\Controllers\ZoneReportController;

Route::prefix('reports')->group(function () {
    Route::get('orders/excel', [OrderReportController::class, 'excel'])->name('orders.excel');
    Route::get('orders/pdf', [OrderReportController::class, 'pdf'])->name('orders.pdf');

    Route::get('riders/excel', [RiderReportController::class, 'excel'])->name('riders.excel');
    Route::get('riders/pdf', [RiderReportController::class, 'pdf'])->name('riders.pdf');

    Route::get('customers/excel', [CustomerReportController::class, 'excel'])->name('customers.excel');
    Route::get('customers/pdf', [CustomerReportController::class, 'pdf'])->name('customers.pdf');

    Route::get('employees/excel', [EmployeeReportController::class, 'excel'])->name('employees.excel');
    Route::get('employees/pdf', [EmployeeReportController::class, 'pdf'])->name('employees.pdf');

    Route::get('loans/excel', [LoanReportController::class, 'excel'])->name('loans.excel');
    Route::get('loans/pdf', [LoanReportController::class, 'pdf'])->name('loans.pdf');

    Route::get('expenses/excel', [ExpenseReportController::class, 'excel'])->name('expenses.excel');
    Route::get('expenses/pdf', [ExpenseReportController::class, 'pdf'])->name('expenses.pdf');

    Route::get('salaries/excel', [SalaryReportController::class, 'excel'])->name('salaries.excel');
    Route::get('salaries/pdf', [SalaryReportController::class, 'pdf'])->name('salaries.pdf');

    Route::get('zones/excel', [ZoneReportController::class, 'excel'])->name('zones.excel');
    Route::get('zones/pdf', [ZoneReportController::class, 'pdf'])->name('zones.pdf');
});
