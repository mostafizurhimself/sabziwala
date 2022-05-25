<?php

namespace App\Models;

use App\Models\Expense;

class ExpenseType extends Model
{
     /**
     * Get all of the Expenses for the Expense type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
