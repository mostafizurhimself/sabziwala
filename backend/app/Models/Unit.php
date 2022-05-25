<?php

namespace App\Models;

class Unit extends Model
{
    /**
     * Determines one-to-many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
       return $this->hasMany(Product::class);
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
}
