<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'How to Register a Business in Nigeria: A Step-by-Step Guide',
                'excerpt' => 'Everything you need to know about reserving a business name and registering with the CAC.',
                'body' => "<p>Registering a business in Nigeria starts with a name availability search at the Corporate Affairs Commission (CAC), followed by reservation, document submission, and certificate issuance.</p><p>This guide walks through each step so you know exactly what to expect before you start.</p>",
                'seo_keywords' => 'how to register a business in Nigeria',
            ],
            [
                'title' => 'Logo vs. Brand Identity: What\'s the Difference?',
                'excerpt' => 'Your logo is one piece of a much bigger system. Here\'s what brand identity actually covers.',
                'body' => "<p>A logo is a single mark. Brand identity is the full system around it: color palette, typography, tone of voice, and how all of that shows up consistently across your website, packaging, and social media.</p>",
                'seo_keywords' => 'logo vs brand identity',
            ],
            [
                'title' => 'How to Set Up WhatsApp Business for Your New Company',
                'excerpt' => 'A practical walkthrough for founders setting up their first business communication channel.',
                'body' => "<p>WhatsApp Business gives you a professional profile, quick replies, and a catalog feature that's especially useful for early-stage founders selling directly to customers.</p>",
                'seo_keywords' => 'how to set up WhatsApp Business',
            ],
        ];

        foreach ($posts as $data) {
            BlogPost::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                $data + ['slug' => Str::slug($data['title']), 'published_at' => now()]
            );
        }
    }
}
