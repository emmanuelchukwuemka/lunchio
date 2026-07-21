<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deliverable;
use Illuminate\Http\Request;

class DeliverableController extends Controller
{
    public function index()
    {
        $deliverables = Deliverable::with(['order.user', 'uploader'])
            ->where('is_current', true)
            ->latest()
            ->paginate(20);

        return view('admin.deliverables.index', compact('deliverables'));
    }
}
