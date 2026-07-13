<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiOnboardingController extends Controller
{
    public function create()
    {
        return view('marketing.ai-onboarding');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'step' => 'required|integer',
        ]);

        $step = $request->input('step');
        $lowerMsg = strtolower($request->input('message'));

        sleep(1); // Simulating AI thinking

        if ($step === 1) {
            // First message received: user describes their business
            return response()->json([
                'reply' => "That sounds like a fantastic idea! Based on what you've told me, you need a solid brand identity and a professional website to look credible. \n\nDo you want me to just set up your Brand & Registration, or do you want the Full Website & Launch Kit too?",
                'next_step' => 2
            ]);
        } elseif ($step === 2) {
            // Second message received: user picks their path
            if (str_contains($lowerMsg, 'full') || str_contains($lowerMsg, 'website') || str_contains($lowerMsg, 'kit')) {
                $packageId = 3; // Premium Package ID (usually 3 based on our seeder)
                $package = "Launchio Premium";
            } else {
                $packageId = 2; // Pro Package ID
                $package = "Launchio Pro";
            }

            return response()->json([
                'reply' => "Perfect! I highly recommend the **{$package}** for your specific needs.\n\nI have pre-configured everything for you. Click the button below to review your customized launch package and proceed to checkout!",
                'next_step' => 3,
                'checkout_url' => route('register') . "?package={$packageId}"
            ]);
        }

        return response()->json([
            'reply' => "I didn't quite catch that. Could you clarify your business idea?",
            'next_step' => $step
        ]);
    }
}
