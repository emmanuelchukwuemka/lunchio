<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::orderBy('category')->orderBy('sort_order')->get()->groupBy('category');

        return view('marketing.faq', compact('faqs'));
    }
}
