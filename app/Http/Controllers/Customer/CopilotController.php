<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CopilotController extends Controller
{
    public function index(): View
    {
        abort_unless(Auth::user()->canAccess('use-copilot'), 403);

        return view('customer.copilot.index');
    }

    public function chat(Request $request)
    {
        abort_unless(Auth::user()->canAccess('use-copilot'), 403);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $lowerMsg = strtolower($userMessage);

        // Simple mock logic to simulate an AI until real OpenAI API key is added
        $response = "I am the Launchio AI Copilot. You said: \"{$userMessage}\".\n\n";
        
        if (str_contains($lowerMsg, 'name')) {
            $response = "Here are 5 name ideas for your business:\n1. Lumina Launch\n2. Nexus Pivot\n3. Vertex Solutions\n4. Zenith Brands\n5. Spark Shift\n\nWhich one of these catches your eye?";
        } elseif (str_contains($lowerMsg, 'brand kit') || str_contains($lowerMsg, 'colors')) {
            $response = "### 🎨 AI Generated Brand Kit\n\n**Primary Color:** Deep Indigo (#1E1B4B)\n**Secondary Color:** Vibrant Teal (#14B8A6)\n**Accent Color:** Coral Pink (#FB7185)\n\n**Typography:**\n- Headings: Sora (Bold, modern, tech-focused)\n- Body: Inter (Clean, readable, versatile)\n\n**Logo Concept:** A geometric 'N' incorporating an upward arrow, signifying growth and pivot.\n\n*Would you like to send these directly to the Launchio design team?*";
        } elseif (str_contains($lowerMsg, 'competitor') || str_contains($lowerMsg, 'market')) {
            $response = "### 📊 Competitor & Market Analysis\n\nBased on your industry, here is a quick market snapshot:\n\n**Top 3 Competitors:**\n1. Market Leader A (High price, complex onboarding)\n2. Local Agency B (Slow delivery, inconsistent quality)\n3. DIY Platform C (Cheap, but zero human support)\n\n**Your Unique Advantage:**\nYou sit perfectly in the middle—offering the speed of a tech platform with the high-quality touch of an agency. Position yourself as the 'Done-For-You' growth partner.";
        } elseif (str_contains($lowerMsg, 'document') || str_contains($lowerMsg, 'privacy') || str_contains($lowerMsg, 'terms')) {
            $response = "### 📄 Generated Business Document\n\n**[Privacy Policy Outline]**\n1. **Information Collection:** We collect names, emails, and usage data.\n2. **Use of Information:** Used strictly for service delivery and platform improvements.\n3. **Data Protection:** Encrypted at rest and in transit.\n4. **Third Parties:** We never sell data to outside advertisers.\n\n*(You can copy this into your legal documents folder!)*";
        } elseif (str_contains($lowerMsg, 'plan') || str_contains($lowerMsg, 'business plan')) {
            $response = "### 📋 1-Page Business Plan Generator\n\n**Target Audience:** Young professionals aged 25-40.\n**Value Proposition:** High-quality, fast, and reliable service.\n**Marketing Channels:** Instagram, TikTok, and Local SEO.\n**Revenue Model:** Tiered subscriptions and one-off service fees.\n\nHow does this sound for a start?";
        } elseif (str_contains($lowerMsg, 'website') || str_contains($lowerMsg, 'landing page')) {
            $response = "### 🌐 Website Structure Suggestion\n\n**Recommended Pages:** Home, About, Services, Testimonials, Contact\n**Hero Headline:** \"Launch your business the smart way.\"\n**Primary CTA:** \"Get Started Today\"\n\n*Want our team to actually build this? Head to My Website and submit your requirements.*";
        } elseif (str_contains($lowerMsg, 'social') || str_contains($lowerMsg, 'caption') || str_contains($lowerMsg, 'instagram') || str_contains($lowerMsg, 'post')) {
            $response = "### 📱 Social Media Content Ideas\n\n1. **Behind-the-scenes** launch story post\n2. **Carousel:** \"3 things we do differently\"\n3. **Reel script:** Quick problem \u{2192} solution hook\n\n*Want a full month planned out? Try the AI Generate button on your Content Calendar.*";
        } else {
            $response = "That's a great thought! As your AI Copilot, I can help you brainstorm business names, write a 1-page business plan, generate a brand kit, draft documents, or analyze competitors. What would you like to focus on next?";
        }

        // Simulating network delay for realism
        sleep(1);

        return response()->json([
            'reply' => $response
        ]);
    }
}
