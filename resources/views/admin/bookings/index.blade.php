<x-admin-layout>
    <x-slot name="header">Expert Bookings</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Expert Bookings</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Expert</th>
                        <th class="px-6 py-4">Scheduled</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-800',
                                'confirmed' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-emerald-100 text-emerald-800',
                                'cancelled' => 'bg-slate-200 text-slate-600',
                            ];
                            $badgeClass = $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">#{{ $booking->id }}</td>
                            <td class="px-6 py-4">{{ $booking->user?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $booking->expert?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $booking->scheduled_at?->format('M d, Y g:ia') ?? 'Not scheduled' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.bookings.status.update', $booking) }}" method="POST" class="inline-flex items-center gap-2 justify-end">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                        @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" @selected($booking->status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">No expert bookings yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
