@php
    $copy = [
        'terms' => [
            'title' => 'Terms of Service',
            'body' => "These Terms of Service govern your use of Launchio's website and platform. By creating an account or purchasing a package, you agree to these terms.\n\nThis is placeholder legal copy — final terminology covering scope of service, corporate registration support boundaries (direct filing vs. licensed CAC agent partnerships vs. advisory-only), liability limits, and dispute resolution should be reviewed by counsel before this page goes live.",
        ],
        'privacy' => [
            'title' => 'Privacy Policy',
            'body' => "Launchio collects and processes personal data in line with the Nigeria Data Protection Act (NDPA) / NDPR. We collect the information you submit through our intake forms and dashboard to deliver your launch kit and provide ongoing support.\n\nThis is placeholder legal copy — a full NDPR-compliant privacy policy covering data retention, third-party processors (payment gateways, email/SMS providers), and your rights as a data subject should be reviewed by counsel before this page goes live.",
        ],
        'refund' => [
            'title' => 'Refund & Cancellation Policy',
            'body' => "Refunds are available before work begins on your order. Once a deliverable has entered production, refund requests are handled on a case-by-case basis.\n\nThis is placeholder legal copy — final refund windows, cancellation terms for Growth tier subscriptions, and partial-refund handling for in-progress orders should be reviewed and finalized before this page goes live.",
        ],
    ];
    $page = $copy[$type];
@endphp

<x-layouts.marketing :title="$page['title']">

    <section class="mx-auto max-w-3xl px-6 py-16">
        <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">{{ $page['title'] }}</h1>
        <p class="mt-2 text-sm text-slate-400">Last updated: {{ now()->format('F j, Y') }}</p>

        <div class="prose prose-slate mt-8 max-w-none whitespace-pre-line">
            {{ $page['body'] }}
        </div>
    </section>

</x-layouts.marketing>
