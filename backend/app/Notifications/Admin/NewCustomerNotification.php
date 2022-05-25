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

class NewCustomerNotification extends Notification
{
    use Queueable, MakeNotification;

    /**
     * New customer instance
     */
    private $customer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
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
            "title"    => "A new customer registered",
            "subtitle" => "Name: {$this->customer->name}",
            "link"     => "/customers/{$this->customer->id}",
            "type"     => NotificationType::INFO(),
        ]);
    }
}
