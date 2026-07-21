<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('My Business') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(!$latestOrder)
                <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                    <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Business Profile Yet</h4>
                    <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">Once you submit your business details through a launch package, your profile will appear here.</p>
                    <a href="{{ route('intake') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                        Get Started
                    </a>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-sora font-bold text-slate-900">{{ $latestOrder->business_name }}</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-600 border border-brand-100">
                            {{ $latestOrder->package->name ?? 'No Package' }}
                        </span>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-slate-500">Description</dt>
                            <dd class="mt-1 text-base text-slate-900">{{ $latestOrder->business_description ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500">Industry</dt>
                            <dd class="mt-1 text-base font-semibold text-slate-900">{{ $latestOrder->industry }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500">Business Stage</dt>
                            <dd class="mt-1 text-base font-semibold text-slate-900">{{ $latestOrder->business_stage }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500">Location</dt>
                            <dd class="mt-1 text-base font-semibold text-slate-900">{{ $latestOrder->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500">Target Audience</dt>
                            <dd class="mt-1 text-base font-semibold text-slate-900">{{ $latestOrder->target_audience }}</dd>
                        </div>
                    </dl>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
