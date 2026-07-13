<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Package;
use App\Models\User;
use App\Notifications\OrderStatusChanged;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderStatusService
{
    /**
     * Which "to" statuses are reachable from each "from" status.
     */
    private const ALLOWED_TRANSITIONS = [
        Order::STATUS_SUBMITTED => [Order::STATUS_IN_PROGRESS],
        Order::STATUS_IN_PROGRESS => [Order::STATUS_IN_REVIEW],
        Order::STATUS_IN_REVIEW => [Order::STATUS_APPROVED, Order::STATUS_IN_PROGRESS],
        Order::STATUS_APPROVED => [Order::STATUS_DELIVERED],
        Order::STATUS_DELIVERED => [],
    ];

    public function createOrder(User $user, Package $package): Order
    {
        $order = Order::create([
            'reference' => 'LNC-'.strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'package_id' => $package->id,
            'status' => Order::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);

        $order->statusLogs()->create([
            'from_status' => null,
            'to_status' => Order::STATUS_SUBMITTED,
            'changed_by_user_id' => $user->id,
            'note' => 'Order submitted.',
        ]);

        return $order;
    }

    public function transition(Order $order, string $toStatus, ?User $changedBy = null, ?string $note = null): Order
    {
        $allowed = self::ALLOWED_TRANSITIONS[$order->status] ?? [];

        if (! in_array($toStatus, $allowed, true)) {
            throw ValidationException::withMessages([
                'status' => "Cannot transition order from \"{$order->status}\" to \"{$toStatus}\".",
            ]);
        }

        $fromStatus = $order->status;

        $order->update([
            'status' => $toStatus,
            'delivered_at' => $toStatus === Order::STATUS_DELIVERED ? now() : $order->delivered_at,
        ]);

        $order->statusLogs()->create([
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'changed_by_user_id' => $changedBy?->id,
            'note' => $note,
        ]);

        $order->user->notify(new OrderStatusChanged($order, $fromStatus, $toStatus));

        return $order;
    }

    public function allowedNextStatuses(Order $order): array
    {
        return self::ALLOWED_TRANSITIONS[$order->status] ?? [];
    }
}
