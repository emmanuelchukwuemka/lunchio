<x-admin-layout>
    <x-slot name="header">Subscriptions</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Active Subscriptions</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Package</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Renews</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($subscriptions as $subscription)
                        @php
                            $statusColors = [
                                'active' => 'bg-emerald-100 text-emerald-800',
                                'past_due' => 'bg-amber-100 text-amber-800',
                                'cancelled' => 'bg-slate-200 text-slate-600',
                            ];
                            $badgeClass = $statusColors[$subscription->status] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">#{{ $subscription->id }}</td>
                            <td class="px-6 py-4">{{ $subscription->user?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $subscription->package?->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $subscription->current_period_end?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($subscription->status !== 'cancelled')
                                    <form action="{{ route('admin.subscriptions.cancel', $subscription) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this subscription?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Cancel</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">No subscriptions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscriptions->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
