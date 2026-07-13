<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * NOTE: pricing, turnaround times, and feature copy below are placeholders.
     * Per the build plan's "Content & Pre-requisites Checklist", these must be
     * replaced with the client's finalized package names, pricing, and feature lists.
     */
    public function run(): void
    {
        $packages = [
            [
                'slug' => 'starter',
                'name' => 'Launchio Starter',
                'tagline' => 'For people who are just starting and need the basics.',
                'description' => 'The essentials to register your business and establish a basic digital presence.',
                'price_one_time' => 75000,
                'price_recurring' => null,
                'recurring_interval' => null,
                'is_recurring' => false,
                'most_popular' => false,
                'turnaround_time' => '7-10 business days',
                'sort_order' => 1,
            ],
            [
                'slug' => 'pro',
                'name' => 'Launchio Pro',
                'tagline' => 'For businesses that want a stronger digital presence.',
                'description' => 'A complete brand and digital launch kit including a landing page.',
                'price_one_time' => 150000,
                'price_recurring' => null,
                'recurring_interval' => null,
                'is_recurring' => false,
                'most_popular' => true,
                'turnaround_time' => '10-14 business days',
                'sort_order' => 2,
            ],
            [
                'slug' => 'premium',
                'name' => 'Launchio Premium',
                'tagline' => 'For businesses that want a full market-ready launch.',
                'description' => 'Full launch kit with a complete marketing asset bundle and sales setup.',
                'price_one_time' => 275000,
                'price_recurring' => null,
                'recurring_interval' => null,
                'is_recurring' => false,
                'most_popular' => false,
                'turnaround_time' => '14-21 business days',
                'sort_order' => 3,
            ],
            [
                'slug' => 'growth',
                'name' => 'Launchio Growth',
                'tagline' => 'For businesses that need ongoing support after launch.',
                'description' => 'Recurring monthly growth support, content, and advisory.',
                'price_one_time' => 275000,
                'price_recurring' => 35000,
                'recurring_interval' => 'monthly',
                'is_recurring' => true,
                'most_popular' => false,
                'turnaround_time' => '14-21 business days, then ongoing',
                'sort_order' => 4,
            ],
        ];

        $packageModels = [];
        foreach ($packages as $data) {
            $packageModels[$data['slug']] = Package::updateOrCreate(['slug' => $data['slug']], $data + ['currency' => 'NGN', 'active' => true]);
        }

        $features = [
            // Starter
            ['name' => 'Business name support', 'pillar' => 'Business Setup'],
            ['name' => 'Business registration guidance', 'pillar' => 'Business Setup'],
            ['name' => 'Logo', 'pillar' => 'Brand Identity'],
            ['name' => 'Basic brand kit', 'pillar' => 'Brand Identity'],
            ['name' => 'Social media page setup', 'pillar' => 'Digital Presence'],
            ['name' => 'Launch flyer', 'pillar' => 'Marketing Assets'],
            ['name' => 'WhatsApp Business setup', 'pillar' => 'Digital Presence'],
            // Pro
            ['name' => 'Website or landing page', 'pillar' => 'Digital Presence'],
            ['name' => 'Google Business Profile', 'pillar' => 'Digital Presence'],
            ['name' => 'Business profile document', 'pillar' => 'Marketing Assets'],
            ['name' => 'Social media launch templates', 'pillar' => 'Marketing Assets'],
            ['name' => 'Official email setup', 'pillar' => 'Digital Presence'],
            ['name' => 'Basic content captions', 'pillar' => 'Marketing Assets'],
            // Premium
            ['name' => 'Full website', 'pillar' => 'Digital Presence'],
            ['name' => 'Payment setup guidance', 'pillar' => 'Business Setup'],
            ['name' => 'Sales/lead capture form', 'pillar' => 'Digital Presence'],
            ['name' => 'Launch campaign designs', 'pillar' => 'Marketing Assets'],
            ['name' => '30-day content plan', 'pillar' => 'Growth Support'],
            ['name' => 'Basic ad setup support', 'pillar' => 'Growth Support'],
            ['name' => 'Customer follow-up system', 'pillar' => 'Growth Support'],
            // Growth
            ['name' => 'Monthly social media designs', 'pillar' => 'Growth Support'],
            ['name' => 'Content planning', 'pillar' => 'Growth Support'],
            ['name' => 'Website updates', 'pillar' => 'Digital Presence'],
            ['name' => 'Marketing campaign support', 'pillar' => 'Growth Support'],
            ['name' => 'Lead generation support', 'pillar' => 'Growth Support'],
            ['name' => 'Business growth advisory', 'pillar' => 'Growth Support'],
        ];

        $featureModels = [];
        foreach ($features as $i => $data) {
            $featureModels[$data['name']] = Feature::updateOrCreate(
                ['name' => $data['name']],
                $data + ['sort_order' => $i]
            );
        }

        // Which features are included per package (progressive inclusion across tiers).
        $inclusionMap = [
            'starter' => [
                'Business name support', 'Business registration guidance', 'Logo', 
                'Basic brand kit', 'Social media page setup', 'Launch flyer', 
                'WhatsApp Business setup'
            ],
            'pro' => [
                'Business name support', 'Business registration guidance', 'Logo', 
                'Basic brand kit', 'Social media page setup', 'Launch flyer', 
                'WhatsApp Business setup',
                'Website or landing page', 'Google Business Profile', 'Business profile document',
                'Social media launch templates', 'Official email setup', 'Basic content captions'
            ],
            'premium' => [
                'Business name support', 'Business registration guidance', 'Logo', 
                'Basic brand kit', 'Social media page setup', 'Launch flyer', 
                'WhatsApp Business setup',
                'Website or landing page', 'Google Business Profile', 'Business profile document',
                'Social media launch templates', 'Official email setup', 'Basic content captions',
                'Full website', 'Payment setup guidance', 'Sales/lead capture form',
                'Launch campaign designs', '30-day content plan', 'Basic ad setup support',
                'Customer follow-up system'
            ],
            'growth' => array_column($features, 'name'), // All features
        ];

        foreach ($inclusionMap as $slug => $includedNames) {
            $package = $packageModels[$slug];
            $syncData = [];
            foreach ($featureModels as $name => $feature) {
                $syncData[$feature->id] = ['included' => in_array($name, $includedNames, true)];
            }
            $package->features()->sync($syncData);
        }
    }
}
