<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Testimonial;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $packages = Package::where('active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('active', true)->orderBy('sort_order')->get();
        $faqs = Faq::orderBy('category')->orderBy('sort_order')->get()->groupBy('category');
        $features = Feature::orderBy('sort_order')->get()->groupBy('pillar');
        $posts = BlogPost::published()->orderByDesc('published_at')->take(3)->get();

        return view('marketing.home', compact('packages', 'testimonials', 'faqs', 'features', 'posts'));
    }

    public function legal(string $type): View
    {
        abort_unless(in_array($type, ['terms', 'privacy', 'refund'], true), 404);

        return view('marketing.legal', compact('type'));
    }
}
