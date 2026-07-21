<x-admin-layout>
    <x-slot name="header">Services</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($services as $service)
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
                <h3 class="font-semibold text-slate-900 mb-1">{{ $service['name'] }}</h3>
                <p class="text-3xl font-sora font-bold text-slate-900 mt-2">{{ $service['delivered_count'] }}</p>
                <p class="text-xs text-slate-500 mt-1">delivered to date</p>
                <a href="{{ route('admin.projects.index', ['category' => $service['category']]) }}" class="inline-block mt-4 text-sm font-medium text-brand-600 hover:text-brand-800">
                    View Projects &rarr;
                </a>
            </div>
        @endforeach

        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
            <h3 class="font-semibold text-slate-900 mb-1">{{ $growthSupport['name'] }}</h3>
            <p class="text-3xl font-sora font-bold text-slate-900 mt-2">{{ $growthSupport['active_subscriptions'] }}</p>
            <p class="text-xs text-slate-500 mt-1">active subscriptions &middot; {{ $growthSupport['content_items'] }} content items scheduled</p>
            <a href="{{ route('admin.subscriptions.index') }}" class="inline-block mt-4 text-sm font-medium text-brand-600 hover:text-brand-800">
                View Subscriptions &rarr;
            </a>
        </div>
    </div>
</x-admin-layout>
