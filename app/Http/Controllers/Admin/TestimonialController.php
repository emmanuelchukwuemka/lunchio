<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_company' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['active'] = true;

        Testimonial::create($validated);

        return back()->with('status', 'Testimonial created successfully.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_company' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $testimonial->update($validated);

        return back()->with('status', 'Testimonial updated successfully.');
    }

    public function toggleActive(Testimonial $testimonial)
    {
        $testimonial->update(['active' => ! $testimonial->active]);

        return back()->with('status', 'Testimonial status updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('status', 'Testimonial deleted successfully.');
    }
}
