<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Follow-ups') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <ul class="divide-y divide-slate-100">
                    @forelse($followUps as $followUp)
                        <li class="p-6">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('crm.index') }}" class="font-medium text-slate-900 hover:text-brand-600">{{ $followUp->contact->name }}</a>
                                <span class="text-xs text-slate-400">{{ $followUp->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <p class="text-sm text-slate-600 mt-1">{{ $followUp->note }}</p>
                        </li>
                    @empty
                        <li class="px-6 py-12 text-center text-slate-400">No follow-ups logged yet. Log one from the CRM page.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
