<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Marketing') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <a href="{{ route('calendar.index') }}" class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
                    <h3 class="font-semibold text-slate-900">Content Plan</h3>
                    <p class="text-sm text-slate-500 mt-1">Your scheduled social posts and captions.</p>
                    <span class="inline-block mt-4 text-sm font-medium text-brand-600">Open Content Calendar &rarr;</span>
                </a>
                <a href="{{ route('campaigns.index') }}" class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition-shadow">
                    <h3 class="font-semibold text-slate-900">Launch Campaigns</h3>
                    <p class="text-sm text-slate-500 mt-1">Track your marketing pushes and promotions.</p>
                    <span class="inline-block mt-4 text-sm font-medium text-brand-600">Open Campaigns &rarr;</span>
                </a>
            </div>

            <div>
                <h3 class="text-xl font-sora font-bold text-slate-900 mb-4">Marketing Assets</h3>
                <x-asset-category-tabs :categories="$categories" empty-title="No Marketing Assets Yet" empty-text="Social media graphics and ad creatives will appear here once delivered." />
            </div>
        </div>
    </div>
</x-app-layout>
