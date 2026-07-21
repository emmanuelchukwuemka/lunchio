<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Subscription') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if($subscriptions->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                    <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Active Subscription</h4>
                    <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">You're not on a recurring plan. Growth package customers get ongoing monthly support.</p>
                    <a href="{{ route('customer.package.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                        View Packages
                    </a>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                    <ul class="divide-y divide-slate-100">
                        @foreach($subscriptions as $subscription)
                            <li class="p-6 flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-slate-900">{{ $subscription->package?->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-slate-500">Renews {{ $subscription->current_period_end?->format('M d, Y') ?? '—' }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $subscription->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
