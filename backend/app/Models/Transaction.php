<?php

namespace App\Models;

use App\Facades\Helper;
use Akaunting\Money\Money;
use Akaunting\Money\Currency;

class Transaction extends Model
{

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['dateFormatted', 'amountFormatted' ];
    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    /**
     * Get date as formated
     */
    public function getDateFormattedAttribute()
    {
        return $this->createdAt->format('d M, Y h:i A');
    }


  /**
     * Get the customer Sub total as formated
     */
    public function getAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->amount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }
}
