<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserNotificationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        // Get the notification
        $notification  = auth()->user()->notifications()->where('id', $id)->first();

        // Mark as read
        $notification->markAsRead();

        return redirect($notification->data['link']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
        // Get the notifications
        $notifications  = auth()->user()->unreadNotifications;
        // Mark all as read
        foreach ($notifications as $notification) {
            $notification->markAsRead();
        }

        return back();
    }

    /**
     * Remove all notification of the user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearAll()
    {
        auth()->user()->notifications()->delete();

        return back();
    }
}
