<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\AdminNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNoteController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:2000'],
        ]);

        $order->adminNotes()->create([
            'staff_id' => Auth::id(),
            'note' => $validated['note'],
        ]);

        return back()->with('status', 'Internal note added successfully.');
    }
}
