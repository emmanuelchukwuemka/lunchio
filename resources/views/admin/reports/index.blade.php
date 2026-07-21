<x-admin-layout>
    <x-slot name="header">Reports</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Orders by Status -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-900">Orders by Status</h3>
            </div>
            <table class="w-full text-left text-sm text-slate-600">
                <tbody class="divide-y divide-slate-100">
                    @foreach($ordersByStatus as $row)
                        <tr>
                            <td class="px-6 py-3">{{ ucwords(str_replace('_', ' ', $row['status'])) }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-slate-900">{{ $row['count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Revenue by Package -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-900">Revenue by Package</h3>
            </div>
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-2">Package</th>
                        <th class="px-6 py-2 text-right">Orders</th>
                        <th class="px-6 py-2 text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($revenueByPackage as $row)
                        <tr>
                            <td class="px-6 py-3">{{ $row['package'] }}</td>
                            <td class="px-6 py-3 text-right">{{ $row['orders'] }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-slate-900">&#8358;{{ number_format($row['revenue'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Leads by Source -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-900">Leads by Source</h3>
            </div>
            <table class="w-full text-left text-sm text-slate-600">
                <tbody class="divide-y divide-slate-100">
                    @forelse($leadsBySource as $row)
                        <tr>
                            <td class="px-6 py-3">{{ $row->source }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-slate-900">{{ $row->count }}</td>
                        </tr>
                    @empty
                        <tr><td class="px-6 py-6 text-center text-slate-400">No leads yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Staff Performance -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-semibold text-slate-900">Staff Performance</h3>
            </div>
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-2">Staff</th>
                        <th class="px-6 py-2 text-right">Assigned</th>
                        <th class="px-6 py-2 text-right">Delivered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($staffPerformance as $staff)
                        <tr>
                            <td class="px-6 py-3">{{ $staff->name }}</td>
                            <td class="px-6 py-3 text-right">{{ $staff->assigned_orders_count }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-slate-900">{{ $staff->delivered_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
