<?php

namespace App\Http\Controllers;

use App\Exports\LoansExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;

class LoanReportController extends Controller
{
        /**
     * Export sale invoices as excel format
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function excel(Request $request)
    {
        return (new LoansExport($request->all()))->download('loans.xlsx');
    }

    /**
     * Export sale invoices as pdf format
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request)
    {
        return (new LoansExport($request->all()))->download('loans.pdf', Excel::DOMPDF);
    }
}
