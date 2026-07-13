<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = \App\Models\BlogPost::latest()->paginate(20);
        return view('admin.blogs.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'cover_image' => 'nullable|url',
            'seo_keywords' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $validated['author_id'] = auth()->id();

        \App\Models\BlogPost::create($validated);

        return redirect()->route('admin.blog.index')->with('status', 'Blog post created successfully.');
    }

    public function edit(\App\Models\BlogPost $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, \App\Models\BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,' . $blog->id,
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'cover_image' => 'nullable|url',
            'seo_keywords' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('status', 'Blog post updated successfully.');
    }

    public function destroy(\App\Models\BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('status', 'Blog post deleted successfully.');
    }
}
