<?php

namespace App\Observers;

use App\Models\Payslip;

class PayslipObserver
{
    /**
     * Handle the Payslip "created" event.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return void
     */
    public function created(Payslip $payslip)
    {
        //    
    }

    /**
     * Handle the Payslip "updated" event.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return void
     */
    public function updated(Payslip $payslip)
    {
        //
    }

    /**
     * Handle the Payslip "deleted" event.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return void
     */
    public function deleted(Payslip $payslip)
    {
        //
    }

    /**
     * Handle the Payslip "restored" event.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return void
     */
    public function restored(Payslip $payslip)
    {
        //
    }

    /**
     * Handle the Payslip "force deleted" event.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return void
     */
    public function forceDeleted(Payslip $payslip)
    {
        //
    }
}