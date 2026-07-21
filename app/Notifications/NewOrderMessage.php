<?php

namespace App\Notifications;

use App\Models\OrderMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderMessage extends Notification
{
    use Queueable;

    public function __construct(
        public OrderMessage $message,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->message->order;

        return (new MailMessage)
            ->subject("New message on order {$order->reference}")
            ->line("{$this->message->user->name} sent a new message on order {$order->reference}:")
            ->line('"' . $this->message->body . '"')
            ->action('View order', route('dashboard'));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->message->order_id,
            'order_message_id' => $this->message->id,
            'from_user_id' => $this->message->user_id,
            'from_user_name' => $this->message->user->name,
            'preview' => str($this->message->body)->limit(100)->toString(),
        ];
    }
}
