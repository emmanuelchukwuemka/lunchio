<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * NOTE: placeholder testimonials until 3-5 real founding-client testimonials
     * are collected, per the build plan's content checklist.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Amaka Obi',
                'role_company' => 'Founder, Obi Skincare',
                'quote' => 'Launchio took my business from an idea on paper to a registered company with a real brand in under three weeks.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Tunde Bakare',
                'role_company' => 'Founder, Bakare Logistics',
                'quote' => 'I didn\'t have to chase five different vendors. Everything I needed to launch was in one place.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Ifeoma Chukwu',
                'role_company' => 'Founder, Chukwu Consulting',
                'quote' => 'The Growth plan\'s content calendar has kept my social media consistent for the first time ever.',
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(['name' => $data['name']], $data + ['active' => true]);
        }
    }
}
