<x-admin-layout>
    <x-slot name="header">Projects</x-slot>

    <div class="mb-6 flex items-center gap-2">
        <a href="{{ route('admin.projects.index') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ !$category ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">All</a>
        @foreach(array_keys(\App\Http\Controllers\Admin\ProjectController::CATEGORY_MAP) as $cat)
            <a href="{{ route('admin.projects.index', ['category' => $cat]) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $category === $cat ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">{{ $cat }}</a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Founder</th>
                        <th class="px-6 py-4">Package</th>
                        <th class="px-6 py-4">Assigned Staff</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $statusColors = [
                            'submitted' => 'bg-amber-100 text-amber-800',
                            'in_progress' => 'bg-blue-100 text-blue-800',
                            'in_review' => 'bg-indigo-100 text-indigo-800',
                            'approved' => 'bg-emerald-100 text-emerald-800',
                            'delivered' => 'bg-emerald-100 text-emerald-800',
                        ];
                    @endphp
                    @forelse($projects as $project)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $project['category'] }}</td>
                            <td class="px-6 py-4">{{ $project['order']->user?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $project['order']->package?->name ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $project['order']->assignedStaff?->name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$project['status']] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucwords(str_replace('_', ' ', $project['status'])) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $project['order']) }}" class="text-brand-600 hover:text-brand-800 font-medium">View Order</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">No projects yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
