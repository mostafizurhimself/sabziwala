<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as Base;

class Permission extends Base
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['label'];

    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(PermissionGroup::class, 'group_id')->withTrashed();
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