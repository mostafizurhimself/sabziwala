<?php

namespace App\Models;

use App\Enums\VatType;
use App\Facades\Helper;
use App\Traits\Sortable;
use Akaunting\Money\Money;
use App\Enums\AddressType;
use App\Enums\ActiveStatus;
use App\Traits\CamelCasing;
use Illuminate\Support\Str;
use Akaunting\Money\Currency;
use App\Traits\HasFilterOption;
use EloquentFilter\Filterable;
use Spatie\MediaLibrary\HasMedia;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;

class Customer extends Authenticatable implements JWTSubject, HasMedia, MustVerifyEmail
{
    use HasFactory, Notifiable, CamelCasing, Filterable, Sortable, InteractsWithMedia, Favoriteability, HasFilterOption;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_login'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name', 'profilePhotoUrl', 'lastLoginForHuman', 'type', 'balanceFormatted'];

    /**
     * Get the custom permissions name of the resource
     *
     * @var array
     */
    public static $permissions = ['view', 'view-any', 'create', 'update'];

    /**
     * Available sortable fields
     *
     * @var array
     */
    public $sortable = ['*'];

    /**
     * Set the default sort citeria
     *
     * @var array
     */
    protected $defaultSortCriteria = ['created_at,desc'];

    /**
     * Get the human readable name of the resource
     *
     * @return string
     */
    public static function readableName()
    {
        $string = Str::kebab((new \ReflectionClass(get_called_class()))->getShortName());
        return Str::plural($string);
    }


    /**
     * Get the user type
     */
    public function getTypeAttribute()
    {
        return 'customer';
    }

    /**
     * Register the media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile-photo')->singleFile();
    }

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\Customer\ResetPasswordNotification($token));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Update total balance
     *
     * @return void
     */
    public function updateBalance()
    {
        $this->balance = $this->transactions()->sum('amount');
        $this->save();
    }

    /**
     * Scope a query to only active customers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', ActiveStatus::ACTIVE());
    }


    /**
     * Get the sale price  as formatted
     */
    public function getBalanceFormattedAttribute()
    {
        $value = new Money(ceil($this->balance), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
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
     * Get the profile-photo media
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->getFirstMediaUrl('profile-photo') ?? null;
    }

    /**
     * Get the full name attribute
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->firstName . " " . $this->lastName;
    }

    /**
     * Get the last login date for humans
     *
     * @return string
     */
    public function getLastLoginForHumanAttribute()
    {
        return $this->lastLogin ? $this->lastLogin->diffForHumans() : null;
    }
}