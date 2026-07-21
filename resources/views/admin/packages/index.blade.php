<x-admin-layout>
    <x-slot name="header">Packages</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Pricing Packages</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Turnaround</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($packages as $package)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                {{ $package->name }}
                                @if($package->most_popular)
                                    <span class="ml-2 inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-brand-100 text-brand-700">Most Popular</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $package->currency }} {{ number_format($package->price_one_time, 0) }}
                                @if($package->is_recurring)
                                    <div class="text-xs text-slate-400">+ {{ $package->currency }} {{ number_format($package->price_recurring, 0) }}/{{ $package->recurring_interval }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $package->turnaround_time ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $package->active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $package->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.packages.toggle', $package) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-brand-600 hover:text-brand-800 font-medium">
                                        {{ $package->active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">No packages configured yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
