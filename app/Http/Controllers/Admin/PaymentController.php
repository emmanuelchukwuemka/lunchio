<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'order', 'invoice'])->latest()->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }
}
