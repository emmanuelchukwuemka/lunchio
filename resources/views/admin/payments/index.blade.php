<x-admin-layout>
    <x-slot name="header">Payments & Revenue</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Payments</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Provider</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Order</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $payment)
                        @php
                            $statusColors = [
                                'success' => 'bg-emerald-100 text-emerald-800',
                                'pending' => 'bg-amber-100 text-amber-800',
                                'failed' => 'bg-red-100 text-red-800',
                            ];
                            $badgeClass = $statusColors[$payment->status] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">#{{ $payment->id }}</td>
                            <td class="px-6 py-4">{{ $payment->user?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ ucfirst($payment->provider) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClass }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $payment->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($payment->order)
                                    <a href="{{ route('admin.orders.show', $payment->order) }}" class="text-brand-600 hover:text-brand-800 font-medium">View Order</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">No payments recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
