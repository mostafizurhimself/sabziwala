<?php

namespace App\Models;

use Carbon\Carbon;
use App\Facades\Helper;
use App\Traits\Trashed;
use Akaunting\Money\Money;
use App\Enums\AddressType;
use App\Traits\HasInvoiceNo;
use Akaunting\Money\Currency;
use App\Models\RefundRequest;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model implements HasMedia
{
    use SoftDeletes, Trashed, InteractsWithMedia, HasInvoiceNo;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['rider_assign_date', 'delivery_date'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['dateFormatted', 'subTotalFormatted', 'grandTotalFormatted','totalDiscountFormatted', 'assignDateFormatted'];

    /**
     * Get the custom permissions name of the resource
     *
     * @var array
     */
    public static $permissions = ['view', 'view-any', 'update'];

    /**
     * Set the model readable id length
     *
     * @var int
     */
    protected static $readableIdLength = 5;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Set the model readable id prefix
     *
     * @var string
     */
    public static function readableIdPrefix()
    {
        return "SW";
    }

    /**
     * Get the supplier address
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function address()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

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
    public function rider()
    {
       return $this->belongsTo(Rider::class);
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
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }



    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refundRequest()
    {
        return $this->hasOne(RefundRequest::class);
    }

    /**
     * Update order total amount
     */
    public function updateSubTotal()
    {
        $this->subTotal = $this->orderItems()->sum('amount');
        $this->save();
    }

    /**
     * Update grand total
     */
    public function updateGrandTotal()
    {
        $this->grandTotal = $this->subTotal - $this->totalDiscount;
        $this->save();
    }

    /**
     * Get date as formatted
     */
    public function getDateFormattedAttribute()
    {
        return $this->createdAt->format('d M, Y h:i A');
    }

        /**
     * Get month as Assign Date
     */
    public function getAssignDateFormattedAttribute()
    {
        return $this->riderAssignDate ? $this->riderAssignDate->format('d M, Y h:i A') : null;
    }

    /**
     * Get billing address attribute
     *
     * @return mixed
     */
    public function getBillingAddressAttribute()
    {
        if ($this->address) {
            return $this->address->where('type', AddressType::BILLING_ADDRESS())->first();
        }
    }

    /**
     * Get shipping address attribute
     *
     * @return mixed
     */
    public function getShippingAddressAttribute()
    {
        if ($this->address) {
            return $this->address->where('type', AddressType::SHIPPING_ADDRESS())->first();
        }
    }

  /**
     * Get the customer Sub total as formated
     */
    public function getSubTotalFormattedAttribute()
    {
        $value = new Money(ceil($this->SubTotal), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

      /**
     * Get the Total  grandtotal as formated
     */
    public function getGrandTotalFormattedAttribute()
    {
        $value = new Money(ceil($this->grandTotal), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

          /**
     * Get the Total  Discount as formated
     */
    public function getTotalDiscountFormattedAttribute()
    {
        $value = new Money(ceil($this->totalDiscount), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }

}
