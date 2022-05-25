<?php

namespace App\Models;

use App\Facades\Helper;
use Akaunting\Money\Money;
use Akaunting\Money\Currency;

class Payslip extends Model
{

        /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['dateFormatted','deductedFormatted', 'paidAmountFormatted', ];


    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    /**
     * Get date as formatted
     */
    public function getDateFormattedAttribute()
    {
        return $this->createdAt->format('d M, Y h:i A');
    }

        /**
     * Get the sale Loan Amount  as formatted
     */
    public function getDeductedFormattedAttribute()
    {
        $value = new Money(ceil($this->deductedAmount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

    /**
     * Get the sale Loan Amount  as formatted
     */
    public function getPaidAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->paidAmount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }


}
