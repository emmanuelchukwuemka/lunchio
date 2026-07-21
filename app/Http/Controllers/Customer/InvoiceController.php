<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->canAccess('view-billing'), 403);

        $payments = \App\Models\Payment::where('user_id', Auth::user()->businessOwner()->id)
            ->with(['order.package', 'invoice'])
            ->latest()
            ->get();

        return view('customer.invoices.index', compact('payments'));
    }

    public function subscriptions()
    {
        abort_unless(Auth::user()->canAccess('view-billing'), 403);

        $subscriptions = Auth::user()->businessOwner()->subscriptions()->with('package')->latest()->get();

        return view('customer.invoices.subscriptions', compact('subscriptions'));
    }

    public function show(Invoice $invoice)
    {
        abort_unless(Auth::user()->canAccess('view-billing'), 403);

        // Ensure user's business owns this invoice
        if ($invoice->payment->user_id !== Auth::user()->businessOwner()->id) {
            abort(403);
        }

        $invoice->load(['payment.order.package', 'payment.user']);

        return view('customer.invoices.show', compact('invoice'));
    }
}
