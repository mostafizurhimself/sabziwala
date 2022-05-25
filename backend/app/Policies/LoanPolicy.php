<?php

namespace App\Policies;

use App\Enums\LoanStatus;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Loan;
use App\Models\User;

class LoanPolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-loans');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loan  $loan
     * @return mixed
     */
    public function view(User $user, Loan $loan)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-loans');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-loans');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loan  $loan
     * @return mixed
     */
    public function update(User $user, Loan $loan)
    {
        return ($user->isSuperAdmin() || $user->hasPermissionTo('update-loans')) && $loan->status == LoanStatus::DRAFT();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loan  $loan
     * @return mixed
     */
    public function delete(User $user, Loan $loan)
    {
        return ($user->isSuperAdmin() || $user->hasPermissionTo('delete-loans')) && $loan->status == LoanStatus::DRAFT();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loan  $loan
     * @return mixed
     */
    public function restore(User $user, Loan $loan)
    {
        return ($user->isSuperAdmin() || $user->hasPermissionTo('restore-loans')) && $loan->status == LoanStatus::DRAFT();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Loan  $loan
     * @return mixed
     */
    public function forceDelete(User $user, Loan $loan)
    {
        return ($user->isSuperAdmin() || $user->hasPermissionTo('force-delete-loans')) && $loan->status == LoanStatus::DRAFT();
    }





}
