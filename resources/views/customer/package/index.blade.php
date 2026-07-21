<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('My Package') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(!$currentPackage)
                <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                    <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Active Package</h4>
                    <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">Choose a launch package to unlock services you can request from the Launchio team.</p>
                    <a href="{{ route('intake') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                        Choose a Package
                    </a>
                </div>
            @else
                <div class="bg-gradient-to-r from-indigo-900 to-brand-800 rounded-3xl p-8 text-white shadow-xl">
                    <p class="text-brand-200 text-sm font-semibold uppercase tracking-wide">Current Package</p>
                    <h3 class="text-3xl font-sora font-bold mt-2">{{ $currentPackage->name }}</h3>
                    <p class="text-brand-100 mt-2 max-w-xl">{{ $currentPackage->tagline }}</p>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-sora font-bold text-slate-900">What You Can Request</h3>
                    <p class="text-sm text-slate-500 mt-1">Services included in your package are unlocked below. Everything else stays visible so you can see what an upgrade unlocks.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                            <tr>
                                <th class="px-6 py-3">Service</th>
                                @foreach($allPackages as $package)
                                    <th class="px-6 py-3 text-center {{ $currentPackage && $package->id === $currentPackage->id ? 'text-brand-600' : '' }}">
                                        {{ $package->name }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php
                                $allFeatures = $allPackages->flatMap->features->unique('id')->sortBy('sort_order');
                            @endphp
                            @foreach($allFeatures as $feature)
                                <tr>
                                    <td class="px-6 py-3 font-medium text-slate-800">{{ $feature->name }}</td>
                                    @foreach($allPackages as $package)
                                        @php
                                            $pkgFeature = $package->features->firstWhere('id', $feature->id);
                                            $included = $pkgFeature?->pivot->included ?? false;
                                            $isCurrent = $currentPackage && $package->id === $currentPackage->id;
                                        @endphp
                                        <td class="px-6 py-3 text-center {{ $isCurrent ? 'bg-brand-50/50' : '' }}">
                                            @if($included)
                                                <svg class="w-5 h-5 text-emerald-500 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @else
                                                <svg class="w-5 h-5 text-slate-300 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($orders->count() > 1)
                <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100 p-8">
                    <h3 class="text-lg font-sora font-bold text-slate-900 mb-4">Package History</h3>
                    <ul class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                            <li class="py-3 flex justify-between text-sm">
                                <span class="text-slate-700">{{ $order->package->name ?? 'N/A' }}</span>
                                <span class="text-slate-400">{{ $order->created_at->format('M d, Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
