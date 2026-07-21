<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('My Website') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                <div class="h-16 w-16 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center mb-6 border border-brand-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Website Requested Yet</h4>
                <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">If your package includes a website, tell us what you need and our team will build it for you.</p>
                <a href="{{ route('website-builder') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                    Submit Website Requirements
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
