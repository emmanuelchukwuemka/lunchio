<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

/**
 * Stub channel for the "future complex WhatsApp Business API configurations"
 * called out in the build plan. Logs the message instead of calling a live
 * API until a WhatsApp Business API provider is selected and configured.
 */
class WhatsAppChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toWhatsApp')) {
            return;
        }

        $phone = $notifiable->routeNotificationFor('whatsapp') ?? $notifiable->phone ?? null;

        if (! $phone) {
            return;
        }

        Log::info('[WhatsApp stub] Would send message', [
            'to' => $phone,
            'message' => $notification->toWhatsApp($notifiable),
        ]);
    }
}
