<x-admin-layout>
    <x-slot name="header">Invoices</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Invoice #</th>
                        <th class="px-6 py-4">Founder</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Order</th>
                        <th class="px-6 py-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4">{{ $invoice->payment?->user?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $invoice->payment?->currency }} {{ number_format($invoice->payment?->amount ?? 0, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($invoice->payment?->order)
                                    <a href="{{ route('admin.orders.show', $invoice->payment->order) }}" class="text-brand-600 hover:text-brand-800 font-medium">#{{ $invoice->payment->order->id }}</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $invoice->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">No invoices yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($invoices->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
