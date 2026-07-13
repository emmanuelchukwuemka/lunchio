<?php

namespace App\Notifications;

use App\Models\Deliverable;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliverableUploaded extends Notification
{
    use Queueable;

    public function __construct(public Deliverable $deliverable) {}

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
            ->subject('A new deliverable is ready for review')
            ->line("\"{$this->deliverable->title}\" is ready for your review on order {$this->deliverable->order->reference}.")
            ->action('Review deliverable', route('dashboard'));
    }

    public function toWhatsApp(object $notifiable): string
    {
        return "Launchio: \"{$this->deliverable->title}\" is ready for review.";
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'deliverable_id' => $this->deliverable->id,
            'order_id' => $this->deliverable->order_id,
            'title' => $this->deliverable->title,
            'message' => "\"{$this->deliverable->title}\" is ready for your review.",
        ];
    }
}
