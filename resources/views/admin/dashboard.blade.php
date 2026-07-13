<x-admin-layout>
    <x-slot name="header">
        Command Center
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Revenue Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-emerald-100 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Revenue</h3>
                    <p class="text-3xl font-sora font-bold text-slate-900">${{ number_format($totalRevenue / 100, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-brand-100 text-brand-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total Users</h3>
                    <p class="text-3xl font-sora font-bold text-slate-900">{{ number_format($totalUsers) }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-amber-100 text-amber-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Pending Orders</h3>
                    <p class="text-3xl font-sora font-bold text-slate-900">{{ number_format($pendingOrders) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-semibold text-slate-900">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">View all &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentOrders as $order)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div>
                            <p class="font-medium text-slate-900">Order #{{ $order->id }}</p>
                            <p class="text-sm text-slate-500">{{ $order->user->name ?? 'Unknown Customer' }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium 
                            {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 
                               ($order->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-800') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-slate-500 text-sm">
                        No recent orders.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Signups -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-semibold text-slate-900">Recent Signups</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">View all &rarr;</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentUsers as $user)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-900 text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400">
                            {{ $user->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-slate-500 text-sm">
                        No recent users.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>
