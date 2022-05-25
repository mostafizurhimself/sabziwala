<?php

namespace App\Models;

use App\Facades\Helper;
use App\Traits\Trashed;
use Akaunting\Money\Money;
use Akaunting\Money\Currency;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes, Trashed;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['product', 'unit'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['amountFormatted', 'rateFormatted'];

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
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
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the rate as formated
     */
    public function getRateFormattedAttribute()
    {
        $value = new Money(ceil($this->rate), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

    /**
     * Get the amount as formated
     */
    public function getAmountFormattedAttribute()
    {
        $value = new Money(ceil($this->amount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }
}
