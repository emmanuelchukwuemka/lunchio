<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ContentCalendarItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentCalendarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Growth tier check temporarily disabled so you can view the calendar
        // $hasGrowth = $user->orders()->whereHas('package', function($q) {
        //     $q->where('is_recurring', true);
        // })->exists();

        // if (!$hasGrowth) {
        //     return redirect()->route('dashboard')->with('error', 'The Content Calendar is exclusive to our Growth Tier.');
        // }

        $items = $user->contentCalendarItems()->orderBy('scheduled_date', 'asc')->get();

        return view('customer.calendar.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'scheduled_date' => ['required', 'date'],
        ]);

        Auth::user()->contentCalendarItems()->create([
            'title' => $validated['title'],
            'notes' => $validated['notes'],
            'scheduled_date' => $validated['scheduled_date'],
            'status' => 'draft',
        ]);

        return back()->with('status', 'Calendar item scheduled.');
    }

    public function aiGenerate(Request $request)
    {
        $user = Auth::user();

        // AI Mock Logic: Generate 5 posts for the upcoming week
        $mockPosts = [
            [
                'title' => 'Instagram Reel: Behind the Scenes',
                'notes' => "Caption: Ever wonder how we get things done so fast? Here's a sneak peek behind the curtain! 🚀 #Launchio #BehindTheScenes\n\nVisuals: Quick 15s timelapse of workspace.",
                'scheduled_date' => now()->addDays(1)->format('Y-m-d'),
            ],
            [
                'title' => 'Twitter/X Thread: 3 Startup Mistakes',
                'notes' => "Thread: 3 mistakes founders make when launching.\n1. Overthinking the logo.\n2. Not collecting emails from day 1.\n3. Waiting for \"perfect\".\n\nLaunchio fixes all 3. Let's talk.",
                'scheduled_date' => now()->addDays(2)->format('Y-m-d'),
            ],
            [
                'title' => 'LinkedIn Post: Why we built this',
                'notes' => "Caption: I was tired of seeing great ideas fail just because they looked unprofessional. So we built the ultimate launch kit... #Entrepreneurship #Growth",
                'scheduled_date' => now()->addDays(4)->format('Y-m-d'),
            ],
            [
                'title' => 'Instagram Carousel: Client Case Study',
                'notes' => "Slide 1: How [Client X] launched in 7 days.\nSlide 2: The Problem.\nSlide 3: Our Solution.\nSlide 4: The Result (200% growth).\nSlide 5: Link in bio to start yours.",
                'scheduled_date' => now()->addDays(6)->format('Y-m-d'),
            ],
            [
                'title' => 'TikTok/Reel: Feature Highlight',
                'notes' => "Caption: Stop paying 5 different freelancers. Our new dashboard brings your website, branding, and marketing into one place. 🎯",
                'scheduled_date' => now()->addDays(7)->format('Y-m-d'),
            ],
        ];

        foreach ($mockPosts as $post) {
            $user->contentCalendarItems()->create([
                'title' => $post['title'],
                'notes' => $post['notes'],
                'scheduled_date' => $post['scheduled_date'],
                'status' => 'draft',
            ]);
        }

        return back()->with('status', 'AI successfully generated 5 new posts for your calendar!');
    }
}
