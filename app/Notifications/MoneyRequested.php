<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MoneyRequested extends Notification
{
    use Queueable;

    protected $amount;
    protected $senderName;
    protected $reason;
    protected $usdAmount;

    public function __construct($amount, $senderName, $reason, $usdAmount)
    {
        $this->amount = $amount;
        $this->senderName = $senderName;
        $this->reason = $reason;
        $this->usdAmount = $usdAmount;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Payment Request: ₱' . number_format($this->amount, 2))
            ->greeting('Hello!')
            ->line($this->senderName . ' is requesting a payment from you.')
            ->line('Amount: ₱' . number_format($this->amount, 2))
            ->line('USD Equivalent: $' . number_format($this->usdAmount, 2)) // This shows your 2nd API's work!
            ->line('Reason: ' . $this->reason)
            ->action('View Request', url('/dashboard'))
            ->line('Thank you for using PayThru!');
    }
}