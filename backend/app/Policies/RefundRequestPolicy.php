<?php

namespace App\Policies;

use App\Enums\RefundRequestStatus;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\RefundRequest;
use App\Models\User;

class RefundRequestPolicy
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
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-any-refund-requests');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return mixed
     */
    public function view(User $user, RefundRequest $refundRequest)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('view-refund-requests');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('create-refund-requests');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return mixed
     */
    public function update(User $user, RefundRequest $refundRequest)
    {
        return ($user->isSuperAdmin() || $user->hasPermissionTo('update-refund-requests')) && $refundRequest->status == RefundRequestStatus::PENDING();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return mixed
     */
    public function delete(User $user, RefundRequest $refundRequest)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('delete-refund-requests');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return mixed
     */
    public function restore(User $user, RefundRequest $refundRequest)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('restore-refund-requests');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return mixed
     */
    public function forceDelete(User $user, RefundRequest $refundRequest)
    {
        return $user->isSuperAdmin() || $user->hasPermissionTo('force-delete-refund-requests');
    }
}