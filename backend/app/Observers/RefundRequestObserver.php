<?php

namespace App\Observers;

use App\Models\User;
use App\Enums\OrderStatus;
use App\Models\Transaction;
use App\Models\RefundRequest;
use App\Enums\RefundRequestStatus;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewRefundRequestNotification;

class RefundRequestObserver
{
    /**
     * Handle the RefundRequest "created" event.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return void
     */
    public function created(RefundRequest $refundRequest)
    {
        // Notify the admin users
        $users = User::permission(['view-refund-requests', 'view-any-refund-requests'])->get();
        Notification::send($users, new NewRefundRequestNotification($refundRequest));
    }

    /**
     * Handle the RefundRequest "updated" event.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return void
     */
    public function updated(RefundRequest $refundRequest)
    {
        //
    }

    /**
     * Handle the RefundRequest "deleted" event.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return void
     */
    public function deleted(RefundRequest $refundRequest)
    {
        //
    }

    /**
     * Handle the RefundRequest "restored" event.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return void
     */
    public function restored(RefundRequest $refundRequest)
    {
        //
    }

    /**
     * Handle the RefundRequest "force deleted" event.
     *
     * @param  \App\Models\RefundRequest  $refundRequest
     * @return void
     */
    public function forceDeleted(RefundRequest $refundRequest)
    {
        //
    }
}

