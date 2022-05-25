<?php

namespace App\Notifications\Admin;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Enums\NotificationType;
use App\Traits\MakeNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewRiderNotification extends Notification
{
    use Queueable, MakeNotification;

    /**
     * New rider instance
     */
    private $rider;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($rider)
    {
        $this->rider = $rider;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return  $this->make([
            "title"    => "A new rider registered",
            "subtitle" => "Name: {$this->rider->name}",
            "link"     => "/riders/{$this->rider->id}",
            "type"     => NotificationType::INFO(),
        ]);
    }
}
