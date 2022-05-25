<?php

namespace App\Models;

use Carbon\Carbon;
use App\Facades\Helper;
use App\Models\Employee;
use Akaunting\Money\Money;
use Akaunting\Money\Currency;
use App\Enums\SalaryStatus;

class Salary extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['totalAmountFormatted',  'totalDeductedFormatted', 'paidAmountFormatted', 'monthFormatted', 'totalDue', 'totalDueFormatted'];

    /**
     * Get the custom permissions name of the resource
     *
     * @var array
     */
    public static $permissions = ['view', 'view-any', 'create', 'update', 'delete', 'can-pay'];

    /**
     * Get the Employee that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zone()
    {
       return $this->belongsTo(Zone::class);
    }

    /**
     * Update total paid amount
     *
     * @return void
     */
    public function updatePaidAmount()
    {
        $this->totalPaid = $this->payslips()->sum('paid_amount');
        $this->save();
    }

    /**
     * Update total deducted amount
     *
     * @return void
     */
    public function updateTotalDeducted()
    {
        $this->totalDeducted = $this->payslips()->sum('deducted_amount');
    }

    /**
     * Update salary status
     *
     * @return void
     */
    public function updateStatus()
    {
        // If status column exists
        if ($this->status != SalaryStatus::DRAFT()) {

            if ($this->totalPaid > 0 && $this->hasDue()) {
                $this->status = SalaryStatus::PARTIAL();
            }

            if (!$this->hasDue()) {
                $this->status = SalaryStatus::PAID();
            }
            $this->save();
        }
    }

    /**
     * Check the salary has due or not
     *
     * @return boolean
     */
    public function hasDue()
    {
        return $this->totalDue > 0;
    }

    /**
     * Get month as formatted
     */
    public function getMonthFormattedAttribute()
    {
        return Carbon::parse($this->month)->format('M Y');
    }

    /**
     * Update Due Amount
     */
    public function getTotalDueAttribute()
    {
        return $this->totalAmount - ($this->totalDeducted + $this->totalPaid);
    }

    /**
     * Get the sale Loan Amount  as formatted
     */
    public function getTotalAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->totalAmount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }


    /**
     * Get the sale Loan Amount  as formatted
     */
    public function getTotalDeductedFormattedAttribute()
    {
        $value = new Money(ceil($this->totalDeducted), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

    /**
     * Get the sale Loan Amount  as formatted
     */
    public function getPaidAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->totalPaid), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

    /**
     * Get the sale Loan Amount  as formatted
     */
    public function getTotalDueFormattedAttribute()
    {
        $value = new Money(ceil($this->totalDue), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }
}
