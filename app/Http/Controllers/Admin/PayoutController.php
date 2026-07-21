<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        return view('admin.payouts.index');
    }
}
