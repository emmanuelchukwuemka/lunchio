<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // If already paid, redirect to dashboard
        if ($order->payments()->where('status', 'successful')->exists()) {
            return redirect()->route('dashboard')->with('status', 'Order is already paid.');
        }

        $order->load(['package.features', 'intakeDraft']);

        return view('customer.checkout.show', compact('order'));
    }

    public function process(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Simulate payment processing logic here
        // In a real app, this would use Stripe, Paystack, etc.

        $isRecurring = $order->package->is_recurring;

        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'package_id' => $order->package_id,
            'amount' => $isRecurring ? $order->package->price_recurring : $order->package->price_one_time,
            'currency' => 'USD',
            'status' => 'success',
            'type' => $isRecurring ? 'subscription' : 'one_time',
            'provider' => 'mock_gateway',
            'provider_reference' => 'mock_txn_' . Str::random(10),
            'paid_at' => now(),
        ]);

        if ($isRecurring) {
            \App\Models\Subscription::create([
                'user_id' => Auth::id(),
                'package_id' => $order->package_id,
                'provider' => 'mock_gateway',
                'provider_subscription_id' => 'mock_sub_' . Str::random(10),
                'status' => 'active',
                'current_period_end' => now()->addMonth(), // Assuming monthly
            ]);
        }

        $payment->invoice()->create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
        ]);

        return redirect()->route('dashboard')
            ->with('status', 'Payment successful! Your order '.$order->reference.' is now officially in progress. You can view your invoice in the dashboard.');
    }
}
