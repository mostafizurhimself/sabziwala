<?php

namespace App\Models;

use App\Traits\HasFilterOption;
use Illuminate\Support\Facades\Cache;

class Zone extends Model
{
   use HasFilterOption;

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
   public function riders()
   {
      return $this->hasMany(Rider::class);
   }

   /**
    * Determines one-to-many relation
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function orders()
   {
      return $this->hasMany(Order::class);
   }


   /**
    * Determines one-to-many relation
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function employees()
   {
      return $this->hasMany(Employee::class);
   }

   /**
    * Determines one-to-many relation
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function salaries()
   {
      return $this->hasMany(Salary::class);
   }

   /**
    * Get the filter options of the model
    *
    * @return array
    */
   public static function filterOptions()
   {
      return Cache::remember(self::readableName(), 3600 * 24, function () {
         return self::orderBy('name', 'asc')->get();
      });
   }
}
