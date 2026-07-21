<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Website;
use App\Models\WebsiteBranding;
use App\Models\WebsitePage;
use App\Models\WebsiteFeature;
use App\Models\WebsiteDomain;
use App\Models\WebsiteHosting;
use App\Models\WebsiteEcommerceSetting;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class WebsiteBuilderWizard extends Component
{
    public $currentStep = 1;
    public $totalSteps = 9; // Adjust based on dynamic flows

    // Step 1: Type
    public $type;

    // Step 2: Information
    public $businessName;
    public $websiteName;
    public $tagline;
    public $description;
    public $industry;
    public $primaryColor = '#000000';
    public $secondaryColor = '#ffffff';
    public $accentColor = '#f3f4f6';
    public $fontStyle = 'Modern';

    // Step 3: Domain
    public $domainChoice;
    public $domainName;

    // Step 4: Hosting
    public $hostingChoice;

    // Step 5: Pages
    public $selectedPages = [];
    public $customPages = '';

    // Step 6: Style
    public $themeStyle;

    // Step 7: Features
    public $selectedFeatures = [];

    // Step 8: AI Prompt
    public $aiPrompt;

    public function mount()
    {
        abort_unless(auth()->user()->canAccess('manage-website'), 403);
        abort_unless(auth()->user()->hasPackageFeatureLike('Website'), 403, 'Your current package does not include a website.');

        $this->currentStep = 1;
    }

    public function nextStep()
    {
        $this->validateStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateStep()
    {
        if ($this->currentStep == 1) {
            $this->validate(['type' => 'required']);
        }
        // Add specific validations per step as needed
    }

    public function submit()
    {
        $this->validateStep();

        $business = auth()->user()->businessOwner();

        $website = Website::create([
            'user_id' => $business->id,
            'order_id' => $business->orders()->latest()->first()?->id,
            'type' => $this->type,
            'name' => $this->websiteName ?: $this->businessName,
            'tagline' => $this->tagline,
            'description' => $this->description,
            'industry' => $this->industry,
            'status' => 'draft',
            'theme' => $this->themeStyle,
            'ai_prompt' => $this->aiPrompt,
        ]);

        WebsiteBranding::create([
            'website_id' => $website->id,
            'primary_color' => $this->primaryColor,
            'secondary_color' => $this->secondaryColor,
            'accent_color' => $this->accentColor,
            'font_style' => $this->fontStyle,
        ]);

        if ($this->domainChoice) {
            WebsiteDomain::create([
                'website_id' => $website->id,
                'type' => $this->domainChoice,
                'domain_name' => $this->domainName,
            ]);
        }

        if ($this->hostingChoice) {
            WebsiteHosting::create([
                'website_id' => $website->id,
                'hosting_type' => $this->hostingChoice,
            ]);
        }

        foreach ($this->selectedPages as $page) {
            if ($page) {
                WebsitePage::create(['website_id' => $website->id, 'name' => $page]);
            }
        }

        foreach ($this->selectedFeatures as $feature) {
            if ($feature) {
                WebsiteFeature::create(['website_id' => $website->id, 'feature_name' => $feature]);
            }
        }

        session()->flash('message', 'Website Setup Complete! Your configuration has been saved.');
        return redirect()->route('websites.show', $website);
    }

    public function generateWithAI()
    {
        $this->validate(['aiPrompt' => 'required|string']);

        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            session()->flash('error', 'OpenAI API key is missing. Please add OPENAI_API_KEY to your .env file to enable the AI website generator.');
            return;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withToken($apiKey)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an expert web designer. Return ONLY a valid JSON object. Keys must be: "businessName" (string), "themeStyle" (one of Minimal, Corporate, Luxury, Dark, Modern, Creative, Classic, Bold), "selectedPages" (array of exact strings from: Home, About, Services, Products, Portfolio, Testimonials, Pricing, Gallery, Blog, FAQ, Contact, Privacy Policy), "selectedFeatures" (array of exact strings from: Live Chat, Contact Form, Newsletter, Booking, WhatsApp Chat, Google Maps, Blog, Reviews, Analytics, SEO, Search).'
                        ],
                        [
                            'role' => 'user',
                            'content' => $this->aiPrompt
                        ]
                    ],
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                $data = json_decode($content, true);
                
                if ($data) {
                    $this->businessName = $data['businessName'] ?? $this->businessName;
                    $this->themeStyle = $data['themeStyle'] ?? $this->themeStyle;
                    $this->selectedPages = $data['selectedPages'] ?? [];
                    $this->selectedFeatures = $data['selectedFeatures'] ?? [];
                    
                    session()->flash('message', 'AI successfully generated your website configuration!');
                    $this->currentStep = 9; // Jump to review
                } else {
                    session()->flash('error', 'Failed to parse AI response. Try again.');
                }
            } else {
                session()->flash('error', 'OpenAI API Error: ' . $response->json('error.message', 'Unknown error'));
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Could not connect to OpenAI: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.website-builder-wizard');
    }
}
