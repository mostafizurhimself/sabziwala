<?php

namespace App\Models;

use App\Models\Loan;
use App\Models\Salary;
use App\Facades\Helper;
use App\Traits\Sortable;
use Akaunting\Money\Money;
use App\Traits\CamelCasing;
use Akaunting\Money\Currency;
use EloquentFilter\Filterable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Employee extends Model implements HasMedia
{
    use  InteractsWithMedia, CamelCasing, Sortable, Filterable;

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
    protected $appends = ['name', 'profilePhotoUrl', 'salaryFormatted'];


    /**
     * Get all of the Loans for the Employees
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Get all of the Loans for the Employees
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salaries()
    {
        return $this->hasMany(Salary::class);
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
     * Register the media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile-photo')->singleFile();
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
     * Get the sale price  as formatted
     */
    public function getSalaryFormattedAttribute()
    {
        $value = new Money(ceil($this->salary), new Currency(Helper::getCurrencyCode()), true);
        return $value->formatWithoutZeroes();
    }
}
