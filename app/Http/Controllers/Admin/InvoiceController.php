<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['payment.user', 'payment.order'])->latest()->paginate(20);

        return view('admin.invoices.index', compact('invoices'));
    }
}
