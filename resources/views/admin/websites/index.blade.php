<x-admin-layout>
    <x-slot name="header">Websites</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Website</th>
                        <th class="px-6 py-4">URL</th>
                        <th class="px-6 py-4">Founder</th>
                        <th class="px-6 py-4">Domain</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Submitted</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $statusColors = [
                            'draft' => 'bg-amber-100 text-amber-800',
                            'in_progress' => 'bg-blue-100 text-blue-800',
                            'live' => 'bg-emerald-100 text-emerald-800',
                        ];
                    @endphp
                    @forelse($websites as $website)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $website->name ?? 'Untitled' }}</td>
                            <td class="px-6 py-4">
                                @if($website->url)
                                    <a href="{{ $website->url }}" target="_blank" class="text-brand-600 hover:text-brand-800">{{ $website->url }}</a>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $website->user?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $website->domain?->domain_name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$website->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucwords(str_replace('_', ' ', $website->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $website->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.websites.show', $website) }}" class="text-brand-600 hover:text-brand-800 font-medium">Manage</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">No website requests submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($websites->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $websites->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
