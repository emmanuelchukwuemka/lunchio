<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('My Assets') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div>
                <h3 class="text-xl font-sora font-bold text-slate-900">All Deliverables</h3>
                <p class="text-slate-500 mt-1">Every file we've delivered for your launches, in one place.</p>
            </div>

            <x-asset-category-tabs :categories="$categories" empty-text="Our team is still working on your launches. Your deliverables will appear here once they are ready." />
        </div>
    </div>
</x-app-layout>
