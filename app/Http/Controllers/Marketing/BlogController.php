<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{

    public function show(BlogPost $blogPost): View
    {
        abort_if($blogPost->published_at === null || $blogPost->published_at->isFuture(), 404);

        return view('marketing.blog.show', ['post' => $blogPost]);
    }
}
