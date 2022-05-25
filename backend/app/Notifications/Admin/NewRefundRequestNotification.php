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

class NewRefundRequestNotification extends Notification
{
    use Queueable, MakeNotification;

    /**
     * New order instance
     */
    private $refund;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($refund)
    {
        $this->refund = $refund;
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
            "title"    => "A new refund requested",
            "subtitle" => "Total amount: {$this->refund->order->grandTotalFormatted}",
            "link"     => "/refund-requests/{$this->refund->id}",
            "type"     => NotificationType::INFO(),
        ]);
    }
}
