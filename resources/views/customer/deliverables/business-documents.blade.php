<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Business Documents') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-sora font-bold text-slate-900">Documents & Registration</h3>
                    <p class="text-slate-500 mt-1">Registration paperwork, company documents, and certificates delivered by our team.</p>
                </div>
                <a href="{{ route('business.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-800">View Business Profile &rarr;</a>
            </div>

            <x-asset-category-tabs :categories="$categories" empty-title="No Documents Yet" empty-text="Registration and company documents will appear here once delivered." />
        </div>
    </div>
</x-app-layout>
