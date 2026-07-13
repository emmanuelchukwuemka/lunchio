<?php

namespace App\Notifications;

use App\Models\Order;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
        public ?string $fromStatus,
        public string $toStatus,
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
            ->subject("Your Launchio order is now {$this->statusLabel()}")
            ->line("Your order {$this->order->reference} has moved to: {$this->statusLabel()}.")
            ->action('View order', route('dashboard'))
            ->line('Thank you for launching with us!');
    }

    public function toWhatsApp(object $notifiable): string
    {
        return "Launchio: your order {$this->order->reference} is now {$this->statusLabel()}.";
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_reference' => $this->order->reference,
            'from_status' => $this->fromStatus,
            'to_status' => $this->toStatus,
            'message' => "Order {$this->order->reference} is now {$this->statusLabel()}.",
        ];
    }

    private function statusLabel(): string
    {
        return str($this->toStatus)->replace('_', ' ')->title();
    }
}
