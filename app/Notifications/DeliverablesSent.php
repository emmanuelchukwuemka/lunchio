<?php

namespace App\Notifications;

use App\Models\Order;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliverablesSent extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', WhatsAppChannel::class];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Your deliverables are ready for review — {$this->order->reference}")
            ->line("Your Launchio team has uploaded new deliverables for order {$this->order->reference}.")
            ->action('Review Now', route('dashboard'))
            ->line('Please review and approve, or request changes.');
    }

    public function toWhatsApp(object $notifiable): string
    {
        return "Launchio: new deliverables are ready for review on order {$this->order->reference}.";
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_reference' => $this->order->reference,
            'message' => "New deliverables are ready for review on order {$this->order->reference}.",
        ];
    }
}
