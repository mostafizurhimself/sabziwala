<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-expenses');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return mixed
     */
    public function view(User $user, Expense $expense)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-expenses');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-expenses');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return mixed
     */
    public function update(User $user, Expense $expense)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-expenses');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return mixed
     */
    public function delete(User $user, Expense $expense)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-expenses');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return mixed
     */
    public function restore(User $user, Expense $expense)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-expenses');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return mixed
     */
    public function forceDelete(User $user, Expense $expense)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-expenses');
    }
}
