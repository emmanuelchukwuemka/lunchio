<x-layouts.marketing title="How It Works">

    <section class="mx-auto max-w-4xl px-6 py-16 text-center">
        <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">How Launchio works</h1>
        <p class="mt-4 text-slate-600">
            Five steps take you from a business idea to a fully delivered launch kit — all tracked from one dashboard.
        </p>
    </section>

    <section class="mx-auto max-w-5xl space-y-10 px-6 pb-20">
        @foreach ([
            [
                'n' => 1,
                'title' => 'Submit your details',
                'desc' => 'Complete a guided intake wizard covering your business definition, industry, target audience, and any existing assets you already have. Your progress saves automatically as you go.',
            ],
            [
                'n' => 2,
                'title' => 'Our team gets to work',
                'desc' => 'Your order moves into production. Depending on your package, this includes business registration filing, brand identity design, and website build — assigned to specialists on our team.',
            ],
            [
                'n' => 3,
                'title' => 'Track progress in your dashboard',
                'desc' => 'Every deliverable moves through a visible status: Submitted → In Progress → In Review → Approved → Delivered, so you always know exactly where things stand.',
            ],
            [
                'n' => 4,
                'title' => 'Review & request revisions',
                'desc' => 'As deliverables land in review, you can approve them or leave revision notes directly against each file — with a full change log kept for every version.',
            ],
            [
                'n' => 5,
                'title' => 'Launch, with ongoing support',
                'desc' => 'Download your complete launch kit from your asset vault. Growth tier subscribers keep going with a monthly content calendar and ongoing growth support.',
            ],
        ] as $step)
            <div class="flex gap-6">
                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full bg-brand-600 text-lg font-bold text-white">
                    {{ $step['n'] }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ $step['title'] }}</h2>
                    <p class="mt-2 text-slate-600">{{ $step['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </section>

    <section class="bg-brand-700">
        <div class="mx-auto max-w-4xl px-6 py-16 text-center">
            <h2 class="text-2xl font-bold text-white sm:text-3xl">Ready to get started?</h2>
            <a href="{{ route('get-started') }}" class="mt-6 inline-block rounded-lg bg-white px-6 py-3 text-sm font-semibold text-brand-700 shadow-sm transition hover:bg-brand-50">
                Start Your Launch
            </a>
        </div>
    </section>

</x-layouts.marketing>
