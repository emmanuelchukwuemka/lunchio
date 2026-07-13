<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Package;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::with('features')->where('active', true)->orderBy('sort_order')->get();
        $features = Feature::orderBy('pillar')->orderBy('sort_order')->get()->groupBy('pillar');
        $faqs = Faq::where('category', 'Pricing')->orderBy('sort_order')->get();

        return view('marketing.packages', compact('packages', 'features', 'faqs'));
    }
}
