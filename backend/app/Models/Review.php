<?php

namespace App\Models;

use App\Traits\Sortable;
use App\Traits\CamelCasing;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Codebyray\ReviewRateable\Models\Rating;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Rating
{
    use HasFactory, CamelCasing, Sortable, Filterable;

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 25;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['dateFormatted'];

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
    protected $defaultSortCriteria = ['id,desc'];

    /**
     * Get the custom permissions name of the resource
     *
     * @var array
     */
    public static $permissions = ['view', 'view-any', 'update', 'delete'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reviewrateable()
    {
        return $this->morphTo(__FUNCTION__, 'reviewrateable_type', 'reviewrateable_id');
    }

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
     * Get month as Assign Date
     */
    public function getDateFormattedAttribute()
    {
        return $this->createdAt ? $this->createdAt->format('d M, Y') : null;
    }
}
