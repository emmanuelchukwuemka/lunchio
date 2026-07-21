<x-admin-layout>
    <x-slot name="header">Deliverables</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">Deliverables Workspace</h3>
            <p class="text-xs text-slate-500">Upload new deliverables from an order's detail page.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Order</th>
                        <th class="px-6 py-4">Uploaded By</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($deliverables as $deliverable)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">#{{ $deliverable->id }}</td>
                            <td class="px-6 py-4">
                                {{ $deliverable->title }}
                                <div class="text-xs text-slate-400">{{ $deliverable->original_filename }} (v{{ $deliverable->version }})</div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ ucfirst(str_replace('_', ' ', $deliverable->type)) }}</td>
                            <td class="px-6 py-4">
                                @if($deliverable->order)
                                    <a href="{{ route('admin.orders.show', $deliverable->order) }}" class="text-brand-600 hover:text-brand-800 font-medium">#{{ $deliverable->order->id }} — {{ $deliverable->order->user?->name }}</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $deliverable->uploader?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $deliverable->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($deliverable->file_path) }}" target="_blank" class="text-brand-600 hover:text-brand-800 font-medium">Download</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">No deliverables uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($deliverables->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $deliverables->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
