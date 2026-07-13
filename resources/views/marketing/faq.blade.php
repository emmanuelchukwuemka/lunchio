<x-layouts.marketing title="FAQ">

    <section class="mx-auto max-w-3xl px-6 py-16">
        <h1 class="text-center text-3xl font-bold text-slate-900 sm:text-4xl">Frequently asked questions</h1>

        <div class="mt-12 space-y-10">
            @forelse ($faqs as $category => $categoryFaqs)
                <div>
                    <h2 class="mb-4 text-lg font-semibold text-slate-900">{{ $category ?? 'General' }}</h2>
                    <div class="space-y-4">
                        @foreach ($categoryFaqs as $faq)
                            <details class="rounded-lg border border-slate-200 p-4">
                                <summary class="cursor-pointer font-semibold text-slate-900">{{ $faq->question }}</summary>
                                <p class="mt-2 text-sm text-slate-600">{{ $faq->answer }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-500">No FAQs yet.</p>
            @endforelse
        </div>
    </section>

</x-layouts.marketing>
