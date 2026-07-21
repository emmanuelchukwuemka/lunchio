<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if($orders->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                    <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Conversations Yet</h4>
                    <p class="text-slate-500 text-sm text-center max-w-sm">Once you have an active launch, you can message your Launchio team right from that launch's page.</p>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100 overflow-hidden">
                    <ul class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                            @php $lastMessage = $order->messages->last(); @endphp
                            <li>
                                <a href="{{ route('orders.show', $order) }}#messages" class="p-6 flex items-center justify-between gap-6 hover:bg-slate-50 transition-colors block">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3">
                                            <h4 class="text-base font-sora font-bold text-slate-900">{{ $order->business_name }}</h4>
                                            <span class="text-xs text-slate-400">&middot; {{ $order->package->name ?? 'N/A' }}</span>
                                        </div>
                                        @if($lastMessage)
                                            <p class="text-sm text-slate-500 mt-1 truncate max-w-xl">
                                                <span class="font-medium text-slate-700">{{ $lastMessage->user->name }}:</span>
                                                {{ $lastMessage->body }}
                                            </p>
                                        @else
                                            <p class="text-sm text-slate-400 italic mt-1">No messages yet on this launch.</p>
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
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
