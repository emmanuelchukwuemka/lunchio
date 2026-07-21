<x-admin-layout>
    <x-slot name="header">Analytics</x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-10">
        <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Revenue</h3>
            <p class="mt-2 text-2xl font-sora font-bold text-slate-900">&#8358;{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Orders</h3>
            <p class="mt-2 text-2xl font-sora font-bold text-slate-900">{{ number_format($totalOrders) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Avg Order Value</h3>
            <p class="mt-2 text-2xl font-sora font-bold text-slate-900">&#8358;{{ number_format($avgOrderValue, 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Active Subscriptions</h3>
            <p class="mt-2 text-2xl font-sora font-bold text-slate-900">{{ number_format($activeSubscriptions) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lead Conversion</h3>
            <p class="mt-2 text-2xl font-sora font-bold text-slate-900">{{ $conversionRate }}%</p>
            <p class="text-xs text-slate-400 mt-1">{{ $totalLeads }} total leads</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-10">
        <!-- Orders over time -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
            <h3 class="font-semibold text-slate-900 mb-6">Orders — Last 30 Days</h3>
            @php $maxOrders = max(1, $ordersByDay->max('count')); @endphp
            <div class="flex items-end gap-1 h-40">
                @foreach($ordersByDay as $day)
                    <div class="flex-1 group relative">
                        <div class="bg-brand-500 hover:bg-brand-600 rounded-t transition-colors" style="height: {{ $day['count'] > 0 ? max(4, ($day['count'] / $maxOrders) * 160) : 2 }}px"></div>
                        <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 hidden group-hover:block bg-slate-900 text-white text-xs rounded px-2 py-1 whitespace-nowrap z-10">
                            {{ $day['label'] }}: {{ $day['count'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Revenue by month -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
            <h3 class="font-semibold text-slate-900 mb-6">Revenue — Last 6 Months</h3>
            @php $maxRevenue = max(1, $revenueByMonth->max('amount')); @endphp
            <div class="flex items-end gap-4 h-40">
                @foreach($revenueByMonth as $month)
                    <div class="flex-1 flex flex-col items-center group relative">
                        <div class="w-full bg-emerald-500 hover:bg-emerald-600 rounded-t transition-colors" style="height: {{ $month['amount'] > 0 ? max(4, ($month['amount'] / $maxRevenue) * 140) : 2 }}px"></div>
                        <span class="mt-2 text-xs text-slate-500">{{ $month['label'] }}</span>
                        <div class="absolute bottom-full mb-1 left-1/2 -translate-x-1/2 hidden group-hover:block bg-slate-900 text-white text-xs rounded px-2 py-1 whitespace-nowrap z-10">
                            &#8358;{{ number_format($month['amount'], 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <!-- Package popularity -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
            <h3 class="font-semibold text-slate-900 mb-6">Package Popularity</h3>
            @php $maxPackageOrders = max(1, $packagePopularity->max('orders_count')); @endphp
            <div class="space-y-4">
                @forelse($packagePopularity as $package)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-slate-700">{{ $package->name }}</span>
                            <span class="text-slate-500">{{ $package->orders_count }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-brand-500 h-2 rounded-full" style="width: {{ ($package->orders_count / $maxPackageOrders) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">No package data yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Lead funnel -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
            <h3 class="font-semibold text-slate-900 mb-6">Lead Funnel</h3>
            @php $maxFunnel = max(1, $leadFunnel->max('count')); @endphp
            <div class="space-y-4">
                @foreach($leadFunnel as $stage)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-slate-700 capitalize">{{ $stage['status'] }}</span>
                            <span class="text-slate-500">{{ $stage['count'] }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ ($stage['count'] / $maxFunnel) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>
