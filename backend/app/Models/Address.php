<?php

namespace App\Models;

use App\Traits\Trashed;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes, Filterable, Trashed;

    /**
     * Get the owning addressable model.
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}