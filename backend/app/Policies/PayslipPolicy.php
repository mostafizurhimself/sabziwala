<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Payslip;
use App\Models\User;

class PayslipPolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-permissions');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payslip  $payslip
     * @return mixed
     */
    public function view(User $user, Payslip $payslip)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-permissions');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-permissions');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payslip  $payslip
     * @return mixed
     */
    public function update(User $user, Payslip $payslip)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('update-permissions');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payslip  $payslip
     * @return mixed
     */
    public function delete(User $user, Payslip $payslip)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-permissions');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payslip  $payslip
     * @return mixed
     */
    public function restore(User $user, Payslip $payslip)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-permissions');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Payslip  $payslip
     * @return mixed
     */
    public function forceDelete(User $user, Payslip $payslip)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-permissions');
    }
}
