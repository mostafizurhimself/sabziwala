<?php

namespace App\Models;

use App\Facades\Helper;
use App\Models\Employee;
use Akaunting\Money\Money;
use Akaunting\Money\Currency;
use App\Enums\LoanStatus;

class Loan extends Model
{
        /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['loanAmountFormatted',  'paidAmountFormatted', 'dueAmountFormatted'];

        /**
     * Get the custom permissions name of the resource
     *
     * @var array
     */
    public static $permissions = ['view', 'view-any', 'create', 'update', 'delete', 'can-confirm'];

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
     * Update salary status
     *
     * @return void
     */
    public function updateStatus()
    {
        // If status column exists
        if ($this->status != LoanStatus::DRAFT()) {

            if ($this->paidAmount > 0 && $this->hasDue()) {
                $this->status = LoanStatus::PARTIAL();
            }

            if (!$this->hasDue()) {
                $this->status = LoanStatus::PAID();
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
        return $this->dueAmount > 0;
    }

     /**
     * Update Due Amount
     */
    public function getDueAmountAttribute()
    {
        return $this->loanAmount - $this->paidAmount;
    }

       /**
     * Get the sale Loan Amount  as formatted
     */
    public function getLoanAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->loanAmount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

       /**
     * Get the Paid Amount  as formatted
     */
    public function getPaidAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->paidAmount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }


     /**
     * Get the employee due amount as formatted
     */
    public function getDueAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->dueAmount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }
}
