<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Founder Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('status'))
                <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-emerald-800">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="bg-gradient-to-br from-brand-900 via-brand-800 to-indigo-900 rounded-3xl shadow-xl overflow-hidden relative">
                <!-- Abstract Glow -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full mix-blend-overlay filter blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
                
                <div class="p-10 md:p-12 relative z-10">
                    <h3 class="text-3xl font-sora font-bold text-white mb-3">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h3>
                    <p class="text-brand-100 text-lg max-w-2xl font-light">Track your active launch kits, download your assets, and manage your business growth all in one place.</p>
                    
                    @if($orders->isEmpty())
                        <div class="mt-8 flex flex-col items-center justify-center p-12 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                            <div class="h-16 w-16 bg-brand-500/20 text-brand-300 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h4 class="text-xl font-sora font-semibold text-white mb-2">Ready to launch?</h4>
                            <p class="text-brand-200 text-sm mb-6 text-center max-w-sm">You haven't started any launch kits yet. Let's get your business off the ground.</p>
                            <a href="{{ route('intake') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl text-brand-900 bg-white hover:bg-slate-50 hover:scale-105 transition-all shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-brand-900 focus:ring-white">
                                Start Your Launch
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            @if($orders->isNotEmpty())
            <!-- Orders Section -->
            <div class="pt-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-sora font-bold text-slate-900">Your Packages</h3>
                    <a href="{{ route('intake') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-800 transition-colors group">
                        Start New Package <span class="inline-block transition-transform group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>

                <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 overflow-hidden">
                    <ul class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                            <li class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1 flex flex-col md:flex-row md:items-center gap-4 md:gap-8">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-600 border border-brand-100">
                                            {{ $order->package->name }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-sora font-bold text-slate-900 leading-tight">{{ $order->business_name ?? 'My Business' }}</h4>
                                        <span class="text-sm font-medium text-slate-500 mt-1 block">Ref: #{{ $order->reference }}</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @php
                                            $statusColors = [
                                                'submitted' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                'in_review' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'delivered' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            ];
                                            $colorClass = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current mr-2"></span>
                                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="flex-shrink-0">
                                    <a href="{{ route('orders.show', $order) }}" class="inline-flex justify-center items-center px-4 py-2 text-sm font-semibold rounded-xl text-slate-700 bg-white border border-slate-200 hover:bg-brand-50 hover:text-brand-700 hover:border-brand-200 transition-colors shadow-sm">
                                        View Details
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

        </div>

    </div>
</x-app-layout>
