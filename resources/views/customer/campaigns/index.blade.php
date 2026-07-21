<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Launch Campaigns') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ showForm: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="flex items-center justify-between">
                <p class="text-slate-500">Track your marketing campaigns &mdash; launch announcements, promotions, and seasonal pushes.</p>
                <button type="button" @click="showForm = !showForm" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
                    New Campaign
                </button>
            </div>

            <div x-show="showForm" x-cloak class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
                <form action="{{ route('campaigns.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @csrf
                    <input type="text" name="name" placeholder="Campaign name" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    <input type="text" name="channel" placeholder="Channel (e.g. Instagram)" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    <select name="status" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                        <option value="planned">Planned</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                    </select>
                    <input type="date" name="starts_at" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    <input type="date" name="ends_at" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    <textarea name="description" placeholder="Description" rows="1" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500 lg:col-span-3"></textarea>
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-md hover:bg-slate-800 transition lg:col-span-3 lg:w-40">Save Campaign</button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <ul class="divide-y divide-slate-100">
                    @forelse($campaigns as $campaign)
                        @php
                            $statusColors = [
                                'planned' => 'bg-amber-100 text-amber-800',
                                'active' => 'bg-emerald-100 text-emerald-800',
                                'completed' => 'bg-slate-200 text-slate-600',
                            ];
                        @endphp
                        <li class="p-6 flex items-center justify-between gap-6">
                            <div>
                                <p class="font-medium text-slate-900">{{ $campaign->name }}</p>
                                <p class="text-sm text-slate-500">{{ $campaign->channel ?? 'No channel set' }} &middot; {{ $campaign->starts_at?->format('M d') }}@if($campaign->ends_at) &ndash; {{ $campaign->ends_at->format('M d, Y') }}@endif</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <form action="{{ route('campaigns.update', $campaign) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                        @foreach(['planned', 'active', 'completed'] as $status)
                                            <option value="{{ $status }}" @selected($campaign->status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Delete this campaign?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-12 text-center text-slate-400">No campaigns yet. Create your first launch campaign above.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
