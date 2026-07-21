<x-admin-layout>
    <x-slot name="header">Businesses</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Businesses on Launchio</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Business</th>
                        <th class="px-6 py-4">Founder</th>
                        <th class="px-6 py-4">Industry</th>
                        <th class="px-6 py-4">Location</th>
                        <th class="px-6 py-4">Package</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($founders as $founder)
                        @php $latestOrder = $founder->orders->first(); @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $latestOrder?->business_name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $founder->name }}</td>
                            <td class="px-6 py-4">{{ $latestOrder?->industry ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $latestOrder?->location ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $latestOrder?->package?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($latestOrder)
                                    <a href="{{ route('admin.orders.show', $latestOrder) }}" class="text-brand-600 hover:text-brand-800 font-medium">View</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">No businesses yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($founders->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $founders->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
