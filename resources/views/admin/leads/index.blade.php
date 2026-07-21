<x-admin-layout>
    <x-slot name="header">Lead Management</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Captured Leads</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Name / Email</th>
                        <th class="px-6 py-4">Business</th>
                        <th class="px-6 py-4">Package Interest</th>
                        <th class="px-6 py-4">Source</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Captured</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                @forelse($leads as $lead)
                    @php
                        $statusColors = [
                            'new' => 'bg-amber-100 text-amber-800',
                            'contacted' => 'bg-blue-100 text-blue-800',
                            'qualified' => 'bg-indigo-100 text-indigo-800',
                            'converted' => 'bg-emerald-100 text-emerald-800',
                            'lost' => 'bg-slate-200 text-slate-600',
                        ];
                        $badgeClass = $statusColors[$lead->status] ?? 'bg-slate-100 text-slate-700';
                    @endphp
                    <tbody class="divide-y divide-slate-100 border-b border-slate-100" x-data="{ notesOpen: false }">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $lead->name }}</div>
                                <div class="text-xs text-slate-500">{{ $lead->email }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $lead->business_name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $lead->packageInterest?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $lead->source ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($lead->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $lead->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center gap-3 justify-end">
                                    <button type="button" @click="notesOpen = !notesOpen" class="text-brand-600 hover:text-brand-800 font-medium" x-text="notesOpen ? 'Hide Notes' : 'Notes ({{ $lead->notes->count() }})'"></button>
                                    <form action="{{ route('admin.leads.status.update', $lead) }}" method="POST" class="inline-flex items-center gap-2 justify-end">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                            @foreach(['new', 'contacted', 'qualified', 'converted', 'lost'] as $status)
                                                <option value="{{ $status }}" @selected($lead->status === $status)>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr x-show="notesOpen" x-cloak>
                            <td colspan="7" class="px-6 py-6 bg-slate-50/70 border-t border-slate-100">
                                @if($lead->notes->isEmpty())
                                    <p class="text-sm text-slate-500 mb-4">No notes yet on this lead.</p>
                                @else
                                    <ul class="space-y-3 mb-4">
                                        @foreach($lead->notes as $note)
                                            <li class="text-sm">
                                                <span class="text-slate-800">{{ $note->note }}</span>
                                                <span class="text-xs text-slate-400 ml-2">{{ $note->user?->name ?? 'Unknown' }} &middot; {{ $note->created_at->format('M d, Y h:i A') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <form action="{{ route('admin.leads.notes.store', $lead) }}" method="POST" class="flex gap-3">
                                    @csrf
                                    <input type="text" name="note" required placeholder="Add a note about this lead..." class="flex-1 text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                    <button type="submit" class="px-4 py-1.5 bg-slate-900 text-white text-sm font-medium rounded-md hover:bg-slate-800 transition">Add</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                @empty
                    <tbody>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">No leads captured yet.</td>
                        </tr>
                    </tbody>
                @endforelse
            </table>
        </div>

        @if($leads->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $leads->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
