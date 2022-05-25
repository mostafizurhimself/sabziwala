<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\ExpenseType;
use App\Models\User;

class ExpenseTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-expense-types');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExpenseType  $expenseType
     * @return mixed
     */
    public function view(User $user, ExpenseType $expenseType)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-expense-types');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-expense-types');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExpenseType  $expenseType
     * @return mixed
     */
    public function update(User $user, ExpenseType $expenseType)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-expense-types');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExpenseType  $expenseType
     * @return mixed
     */
    public function delete(User $user, ExpenseType $expenseType)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-expense-types');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExpenseType  $expenseType
     * @return mixed
     */
    public function restore(User $user, ExpenseType $expenseType)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-expense-types');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ExpenseType  $expenseType
     * @return mixed
     */
    public function forceDelete(User $user, ExpenseType $expenseType)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-expense-types');
    }
}
