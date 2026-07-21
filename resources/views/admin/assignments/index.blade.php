<x-admin-layout>
    <x-slot name="header">Assignments</x-slot>

    <!-- Staff Workload -->
    <div class="mb-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($staffMembers as $staff)
            <div class="bg-white rounded-xl p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-900 truncate">{{ $staff->name }}</p>
                <p class="mt-1 text-2xl font-sora font-bold text-slate-900">{{ $staff->active_order_count }}</p>
                <p class="text-xs text-slate-400">active order{{ $staff->active_order_count === 1 ? '' : 's' }}</p>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Unassigned & Active Orders</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Order</th>
                        <th class="px-6 py-4">Founder</th>
                        <th class="px-6 py-4">Package</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Assigned To</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-brand-600">#{{ $order->reference }}</a>
                            </td>
                            <td class="px-6 py-4">{{ $order->user?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $order->package?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ ucwords(str_replace('_', ' ', $order->status)) }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.assignments.update', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="assigned_staff_id" onchange="this.form.submit()" class="text-xs rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                        <option value="">Unassigned</option>
                                        @foreach($staffMembers as $staff)
                                            <option value="{{ $staff->id }}" @selected($order->assigned_staff_id === $staff->id)>{{ $staff->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">No active orders.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
