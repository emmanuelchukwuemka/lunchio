<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How long does it take to receive my launch kit?',
                'answer' => 'Turnaround time depends on your package tier, ranging from 7-10 business days for Starter up to 14-21 business days for Premium and Growth. Exact timelines are shown on the Packages page.',
                'category' => 'Timelines',
            ],
            [
                'question' => 'What exactly is included in business registration support?',
                'answer' => 'We guide you through CAC business name reservation and registration and TIN setup. We are not a licensed law firm; for complex legal structuring we can refer you to a partner.',
                'category' => 'Legal & Registration',
            ],
            [
                'question' => 'Can I upgrade my package after purchase?',
                'answer' => 'Yes. You can upgrade at any time from your dashboard, paying only the price difference between your current and new package.',
                'category' => 'Pricing',
            ],
            [
                'question' => 'What is your refund policy?',
                'answer' => 'Refunds are available before work begins on your order. Once a deliverable has entered production, refunds are handled on a case-by-case basis per our Refund Policy.',
                'category' => 'Pricing',
            ],
            [
                'question' => 'What happens after my order is delivered?',
                'answer' => 'All your deliverables remain available in your dashboard\'s asset vault. Growth tier subscribers also unlock ongoing monthly support.',
                'category' => 'Timelines',
            ],
        ];

        foreach ($faqs as $i => $data) {
            Faq::updateOrCreate(['question' => $data['question']], $data + ['sort_order' => $i]);
        }
    }
}
