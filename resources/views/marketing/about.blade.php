<x-layouts.marketing title="About">

    <section class="mx-auto max-w-4xl px-6 py-16">
        <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">About Launchio</h1>
        <p class="mt-6 text-slate-600">
            Launchio was built out of a simple frustration: launching a business in Nigeria meant juggling a CAC
            agent, a freelance designer, a website builder, and a marketing consultant — none of whom talked to each
            other, and none of whom could tell you where things actually stood.
        </p>
        <p class="mt-4 text-slate-600">
            We set out to build the platform we wished existed: one place to submit your business details once, track
            every deliverable as it's produced, and walk away with a complete, launch-ready kit.
        </p>
    </section>

    <section class="bg-slate-50 py-16">
        <div class="mx-auto max-w-4xl px-6">
            <h2 class="text-2xl font-bold text-slate-900">Our mission</h2>
            <p class="mt-4 text-slate-600">
                To make launching a legitimate, well-branded business in Nigeria as simple as filling out one form —
                removing the coordination tax that early-stage founders pay in time and money.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-6 py-16">
        <h2 class="mb-8 text-center text-2xl font-bold text-slate-900">Meet the team</h2>
        <div class="grid gap-6 sm:grid-cols-3">
            @foreach ([
                ['name' => 'Team bio placeholder', 'role' => 'Founder & CEO'],
                ['name' => 'Team bio placeholder', 'role' => 'Head of Design'],
                ['name' => 'Team bio placeholder', 'role' => 'Head of Operations'],
            ] as $member)
                <div class="rounded-xl border border-slate-200 p-6 text-center">
                    <div class="mx-auto h-20 w-20 rounded-full bg-slate-200"></div>
                    <p class="mt-4 font-semibold text-slate-900">{{ $member['name'] }}</p>
                    <p class="text-sm text-slate-500">{{ $member['role'] }}</p>
                </div>
            @endforeach
        </div>
        <p class="mt-6 text-center text-xs text-slate-400">Team bios pending final content from the founding team.</p>
    </section>

</x-layouts.marketing>
