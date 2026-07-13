<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('My Launches') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-xl font-sora font-bold text-slate-900">Active & Past Launches</h3>
                    <p class="text-slate-500 mt-1">Track the progress of your brand kits, website builds, and social packages.</p>
                </div>
                <a href="{{ route('intake') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
                    Start New Launch
                </a>
            </div>

            @if($orders->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                    <div class="h-16 w-16 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center mb-6 border border-brand-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Launches Yet</h4>
                    <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">You haven't purchased any launch kits. Ready to start building your business?</p>
                    <a href="{{ route('intake') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                        Explore Packages
                    </a>
                </div>
            @else
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
                                        <span class="text-sm font-medium text-slate-500 mt-1 block">Ref: #{{ $order->reference }} &bull; Submitted {{ $order->created_at->format('M d, Y') }}</span>
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
            @endif

        </div>
    </div>
</x-app-layout>
