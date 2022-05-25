<?php

namespace App\Models;

use App\Facades\Helper;
use Akaunting\Money\Money;
use App\Models\ExpenseType;
use Akaunting\Money\Currency;

class Expense extends Model
{

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['amountFormatted'];

    /**
     * Get the ExpenseType that owns the Expense
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }

    /**
     * Get the sale price  as formatted
     */
    public function getAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->amount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }
}
