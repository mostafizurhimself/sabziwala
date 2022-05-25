<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionGroup extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['label'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['permissions'];


    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_id');
    }

    /**
     * Get the label attribute
     *
     * @return string
     */
    public function getLabelAttribute()
    {
        return Str::title(str_replace("-", " ", $this->name));
    }
}