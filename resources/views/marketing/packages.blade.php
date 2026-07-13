<x-layouts.marketing title="Packages & Pricing">

    <section class="mx-auto max-w-4xl px-6 py-16 text-center">
        <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">Packages & Pricing</h1>
        <p class="mt-4 text-slate-600">All prices in Nigerian Naira (NGN). Growth includes an ongoing monthly subscription.</p>
    </section>

    <section class="mx-auto max-w-7xl px-6 pb-16">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($packages as $package)
                <div class="relative flex flex-col rounded-2xl border {{ $package->most_popular ? 'border-brand-500 shadow-lg' : 'border-slate-200' }} bg-white p-6">
                    @if ($package->most_popular)
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-accent-500 px-3 py-1 text-xs font-semibold text-white">Most Popular</span>
                    @endif
                    <h3 class="text-lg font-bold text-slate-900">{{ $package->name }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $package->tagline }}</p>
                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        ₦{{ number_format($package->price_one_time) }}
                    </p>
                    @if ($package->is_recurring)
                        <p class="text-sm font-medium text-slate-500">+ ₦{{ number_format($package->price_recurring) }}/{{ $package->recurring_interval }}</p>
                    @endif
                    <p class="mt-3 text-xs text-slate-500">Turnaround: {{ $package->turnaround_time }}</p>
                    <a href="{{ route('get-started') }}?package={{ $package->id }}" class="mt-6 rounded-lg bg-brand-600 px-4 py-2 text-center text-sm font-semibold text-white transition hover:bg-brand-700">
                        Choose {{ $package->name }}
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Comparison matrix --}}
    <section class="mx-auto max-w-7xl overflow-x-auto px-6 pb-16">
        <h2 class="mb-6 text-2xl font-bold text-slate-900">Compare every feature</h2>
        <table class="w-full min-w-[720px] border-collapse text-left text-sm">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="py-3 pr-4 font-semibold text-slate-900">Feature</th>
                    @foreach ($packages as $package)
                        <th class="px-4 py-3 text-center font-semibold text-slate-900">{{ $package->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($features as $pillar => $pillarFeatures)
                    <tr class="bg-slate-50">
                        <td colspan="{{ $packages->count() + 1 }}" class="px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            {{ $pillar }}
                        </td>
                    </tr>
                    @foreach ($pillarFeatures as $feature)
                        <tr class="border-b border-slate-100">
                            <td class="py-3 pr-4 text-slate-700">{{ $feature->name }}</td>
                            @foreach ($packages as $package)
                                @php
                                    $pivot = $package->features->firstWhere('id', $feature->id)?->pivot;
                                @endphp
                                <td class="px-4 py-3 text-center">
                                    @if ($pivot?->included)
                                        <svg class="mx-auto h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    @else
                                        <span class="text-slate-300">—</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </section>

    @if ($faqs->isNotEmpty())
        <section class="mx-auto max-w-4xl px-6 pb-20">
            <h2 class="mb-6 text-2xl font-bold text-slate-900">Pricing questions</h2>
            <div class="space-y-4">
                @foreach ($faqs as $faq)
                    <details class="rounded-lg border border-slate-200 p-4">
                        <summary class="cursor-pointer font-semibold text-slate-900">{{ $faq->question }}</summary>
                        <p class="mt-2 text-sm text-slate-600">{{ $faq->answer }}</p>
                    </details>
                @endforeach
            </div>
            <p class="mt-6 text-sm text-slate-500">
                Have more questions? Visit the full <a href="{{ route('faq') }}" class="font-semibold text-brand-700">FAQ page</a>.
            </p>
        </section>
    @endif

</x-layouts.marketing>
