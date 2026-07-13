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
        $payments = \App\Models\Payment::where('user_id', Auth::id())
            ->with(['order.package', 'invoice'])
            ->latest()
            ->get();

        return view('customer.invoices.index', compact('payments'));
    }

    public function show(Invoice $invoice)
    {
        // Ensure user owns this invoice
        if ($invoice->payment->user_id !== Auth::id()) {
            abort(403);
        }

        $invoice->load(['payment.order.package', 'payment.user']);

        return view('customer.invoices.show', compact('invoice'));
    }
}
