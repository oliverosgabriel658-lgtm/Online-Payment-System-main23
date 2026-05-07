<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceived extends Notification
{
    use Queueable;

    protected $amount;
    protected $senderName;

    public function __construct($amount, $senderName)
    {
        $this->amount = $amount;
        $this->senderName = $senderName;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Money Received!')
                    ->greeting('Hello!')
                    ->line('You have received a payment of ₱' . number_format($this->amount, 2) . '.')
                    ->line('Sender: ' . $this->senderName)
                    ->action('View Dashboard', url('/dashboard'))
                    ->line('Thank you for using PayThru!');
    }
}