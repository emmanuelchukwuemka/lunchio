<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Sales Analytics') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Spent</h3>
                    <p class="mt-2 text-2xl font-sora font-bold text-slate-900">&#8358;{{ number_format($totalSpent, 2) }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Orders</h3>
                    <p class="mt-2 text-2xl font-sora font-bold text-slate-900">{{ $totalOrders }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Active Subscriptions</h3>
                    <p class="mt-2 text-2xl font-sora font-bold text-slate-900">{{ $activeSubscriptions }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">My CRM Contacts</h3>
                    <p class="mt-2 text-2xl font-sora font-bold text-slate-900">{{ $contactFunnel['leads'] + $contactFunnel['customers'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $contactFunnel['leads'] }} leads &middot; {{ $contactFunnel['customers'] }} customers</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
                <h3 class="font-semibold text-slate-900 mb-6">Spend — Last 6 Months</h3>
                @php $maxSpend = max(1, $spendByMonth->max('amount')); @endphp
                <div class="flex items-end gap-4 h-40">
                    @foreach($spendByMonth as $month)
                        <div class="flex-1 flex flex-col items-center group relative">
                            <div class="w-full bg-brand-500 hover:bg-brand-600 rounded-t transition-colors" style="height: {{ $month['amount'] > 0 ? max(4, ($month['amount'] / $maxSpend) * 140) : 2 }}px"></div>
                            <span class="mt-2 text-xs text-slate-500">{{ $month['label'] }}</span>
                            <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 hidden group-hover:block bg-slate-900 text-white text-xs rounded px-2 py-1 whitespace-nowrap z-10">
                                &#8358;{{ number_format($month['amount'], 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6">
                <p class="text-sm text-slate-500">
                    <strong class="text-slate-700">Website & Marketing Analytics</strong> aren't shown here yet &mdash; there's no visitor-tracking or ad-performance data connected to your website or campaigns. This page only reflects your real transaction history with Launchio.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
