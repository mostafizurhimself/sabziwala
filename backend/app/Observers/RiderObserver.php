<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Rider;
use App\Notifications\Admin\NewRiderNotification;
use Illuminate\Support\Facades\Notification;

class RiderObserver
{
    /**
     * Handle the Rider "created" event.
     *
     * @param  \App\Models\Rider  $rider
     * @return void
     */
    public function created(Rider $rider)
    {
         // Notify the admin users
         $users = User::permission(['view-riders', 'view-any-riders'])->get();
         Notification::send($users, new NewRiderNotification($rider));
    }

    /**
     * Handle the Rider "updated" event.
     *
     * @param  \App\Models\Rider  $rider
     * @return void
     */
    public function updated(Rider $rider)
    {
        //
    }

    /**
     * Handle the Rider "deleted" event.
     *
     * @param  \App\Models\Rider  $rider
     * @return void
     */
    public function deleted(Rider $rider)
    {
        //
    }

    /**
     * Handle the Rider "restored" event.
     *
     * @param  \App\Models\Rider  $rider
     * @return void
     */
    public function restored(Rider $rider)
    {
        //
    }

    /**
     * Handle the Rider "force deleted" event.
     *
     * @param  \App\Models\Rider  $rider
     * @return void
     */
    public function forceDeleted(Rider $rider)
    {
        //
    }
}
