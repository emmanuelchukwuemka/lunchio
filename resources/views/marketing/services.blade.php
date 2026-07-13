<x-layouts.marketing title="Services">

    <section class="mx-auto max-w-4xl px-6 py-16 text-center">
        <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">Services</h1>
        <p class="mt-4 text-slate-600">Everything Launchio delivers, organized into five core technical pillars.</p>
    </section>

    <section class="mx-auto max-w-6xl space-y-12 px-6 pb-20">
        @foreach ([
            [
                'title' => 'Business Setup',
                'scope' => 'We guide you through reserving your business name, filing CAC registration, and setting up your Tax ID (TIN) — the legal foundation every business needs before it can trade.',
                'metrics' => ['Business name reservation', 'CAC registration guidance', 'TIN setup guidance'],
            ],
            [
                'title' => 'Brand Identity',
                'scope' => 'A logo alone isn\'t a brand. We build a full identity system — color palette, typography, and a style guide — so everything you put out looks consistent.',
                'metrics' => ['Logo design', 'Color & typography system', 'Brand style guide PDF'],
            ],
            [
                'title' => 'Digital Presence',
                'scope' => 'Your first touchpoint with customers. We stand up a landing page, business email, and a Google Business Profile so people can find and trust you online.',
                'metrics' => ['1-page landing website', 'Business email setup', 'Google Business Profile'],
            ],
            [
                'title' => 'Marketing Assets',
                'scope' => 'Templates you can put to work immediately — for social media, print, and pitching investors or partners.',
                'metrics' => ['Social media starter kit', 'Business card & flyer templates', 'Pitch deck template'],
            ],
            [
                'title' => 'Growth Support',
                'scope' => 'Launching is the start, not the finish line. Growth tier subscribers get ongoing support to keep momentum after delivery.',
                'metrics' => ['30-day post-launch support', 'Monthly content calendar', 'Monthly growth strategy call'],
            ],
        ] as $pillar)
            <div class="grid gap-6 rounded-2xl border border-slate-200 p-8 sm:grid-cols-3">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $pillar['title'] }}</h2>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-slate-600">{{ $pillar['scope'] }}</p>
                    <ul class="mt-4 flex flex-wrap gap-2">
                        @foreach ($pillar['metrics'] as $metric)
                            <li class="rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-700">{{ $metric }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </section>

    <section class="mx-auto max-w-5xl px-6 pb-20">
        <h2 class="mb-6 text-center text-2xl font-bold text-slate-900">See which package fits</h2>
        <div class="grid gap-4 sm:grid-cols-4">
            @foreach ($packages as $package)
                <a href="{{ route('packages') }}" class="rounded-xl border border-slate-200 p-5 text-center transition hover:border-brand-300">
                    <p class="font-semibold text-slate-900">{{ $package->name }}</p>
                    <p class="mt-1 text-sm text-slate-500">₦{{ number_format($package->price_one_time) }}</p>
                </a>
            @endforeach
        </div>
    </section>

</x-layouts.marketing>
