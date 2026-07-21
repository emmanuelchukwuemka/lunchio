<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\NewOrderMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderMessageController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $user = Auth::user();
        $isOwner = $order->user_id === $user->businessOwner()->id && $user->canAccess('manage-orders');
        $isStaff = $user->hasAnyRole(['admin', 'staff']);

        abort_unless($isOwner || $isStaff, 403);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $message = $order->messages()->create([
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $message->load('user');

        $recipient = $isStaff
            ? $order->user
            : ($order->assignedStaff ?? \App\Models\User::role('admin')->first());

        if ($recipient && $recipient->id !== $user->id) {
            $recipient->notify(new NewOrderMessage($message));
        }

        return back()->with('status', 'Message sent.');
    }
}
