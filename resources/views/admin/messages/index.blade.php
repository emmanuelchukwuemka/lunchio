<x-admin-layout>
    <x-slot name="header">Messages</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <ul class="divide-y divide-slate-100">
            @forelse($orders as $order)
                @php $lastMessage = $order->messages->last(); @endphp
                <li>
                    <a href="{{ route('admin.orders.show', $order) }}" class="p-6 flex items-center justify-between gap-6 hover:bg-slate-50 transition-colors block">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3">
                                <h4 class="text-base font-sora font-bold text-slate-900">{{ $order->user?->name ?? 'Unknown' }}</h4>
                                <span class="text-xs text-slate-400">&middot; {{ $order->package?->name ?? 'N/A' }}</span>
                                <span class="text-xs text-slate-400">&middot; Assigned: {{ $order->assignedStaff?->name ?? 'Unassigned' }}</span>
                            </div>
                            @if($lastMessage)
                                <p class="text-sm text-slate-500 mt-1 truncate max-w-xl">
                                    <span class="font-medium text-slate-700">{{ $lastMessage->user->name }}:</span>
                                    {{ $lastMessage->body }}
                                </p>
                            @endif
                        </div>
                        <div class="flex-shrink-0 text-right">
                            @if($lastMessage)
                                <p class="text-xs text-slate-400">{{ $lastMessage->created_at->diffForHumans() }}</p>
                            @endif
                            <span class="text-sm font-semibold text-brand-600">Open &rarr;</span>
                        </div>
                    </a>
                </li>
            @empty
                <li class="px-6 py-12 text-center text-slate-400">No conversations yet.</li>
            @endforelse
        </ul>

        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
