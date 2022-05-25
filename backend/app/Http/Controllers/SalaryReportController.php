<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Exports\SalariesExport;
use App\Http\Controllers\Controller;

class SalaryReportController extends Controller
{
        /**
     * Export sale invoices as excel format
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function excel(Request $request)
    {
        return (new SalariesExport($request->all()))->download('salaries.xlsx');
    }

    /**
     * Export sale invoices as pdf format
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request)
    {
        return (new SalariesExport($request->all()))->download('salaries.pdf', Excel::DOMPDF);
    }
}
