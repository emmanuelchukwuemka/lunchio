<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Brand Assets') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div>
                <h3 class="text-xl font-sora font-bold text-slate-900">Your Brand Kit</h3>
                <p class="text-slate-500 mt-1">Logo, brand kit, business card, and letterhead files delivered by our design team.</p>
            </div>

            <x-asset-category-tabs :categories="$categories" empty-title="No Brand Assets Yet" empty-text="Once our design team delivers your logo and brand kit, they'll appear here." />
        </div>
    </div>
</x-app-layout>
