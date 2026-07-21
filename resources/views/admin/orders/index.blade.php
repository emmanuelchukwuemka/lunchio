<x-admin-layout>
    <x-slot name="header">
        Active Orders Queue
    </x-slot>

    <div class="mb-10">
        <h2 class="text-xl font-medium text-slate-900">All Client Orders</h2>
        <p class="mt-2 text-sm text-slate-500">Manage and track the progress of all active client projects.</p>
    </div>

    <!-- Staff Workload -->
    <div class="mb-10 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($staffMembers as $staff)
            <div class="bg-white rounded-xl p-4 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-900 truncate">{{ $staff->name }}</p>
                <p class="mt-1 text-2xl font-sora font-bold text-slate-900">{{ $staff->active_order_count }}</p>
                <p class="text-xs text-slate-400">active order{{ $staff->active_order_count === 1 ? '' : 's' }}</p>
            </div>
        @endforeach
    </div>

    @if($orders->isEmpty())
        <div class="py-20 text-center">
            <h3 class="text-sm font-medium text-slate-900">No orders</h3>
            <p class="mt-1 text-sm text-slate-500">There are currently no active orders in the queue.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th scope="col" class="py-3 pr-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ref / Date</th>
                        <th scope="col" class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Client</th>
                        <th scope="col" class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Package</th>
                        <th scope="col" class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Assigned To</th>
                        <th scope="col" class="relative py-3 pl-6"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($orders as $order)
                        <tr class="group transition-colors hover:bg-slate-50/50">
                            <td class="py-4 pr-6 align-top">
                                <div class="text-sm font-medium text-slate-900">#{{ $order->reference }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $order->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="py-4 px-6 align-top">
                                <div class="text-sm font-medium text-slate-900">{{ $order->user->name }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $order->business_name }}</div>
                            </td>
                            <td class="py-4 px-6 align-top">
                                <div class="text-sm font-medium text-slate-700">
                                    {{ optional($order->package)->name ?? 'Unknown' }}
                                </div>
                            </td>
                            <td class="py-4 px-6 align-top">
                                @php
                                    $statusColors = [
                                        'submitted' => 'text-amber-600',
                                        'in_progress' => 'text-blue-600',
                                        'in_review' => 'text-purple-600',
                                        'approved' => 'text-emerald-600',
                                        'delivered' => 'text-emerald-600',
                                    ];
                                    $colorClass = $statusColors[$order->status] ?? 'text-slate-600';
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="h-1.5 w-1.5 rounded-full {{ str_replace('text-', 'bg-', $colorClass) }}"></span>
                                    <span class="text-sm font-medium {{ $colorClass }}">
                                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6 align-top">
                                <form action="{{ route('admin.orders.assign', $order) }}" method="POST">
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
                            <td class="py-4 pl-6 align-top text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-medium text-brand-600 hover:text-brand-900 transition-colors">
                                    Manage &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
            <div class="mt-8 pt-4 border-t border-slate-200">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
</x-admin-layout>
