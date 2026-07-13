<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Billing & Invoices') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-xl font-sora font-bold text-slate-900">Payment History</h3>
                    <p class="text-slate-500 mt-1">View your past transactions and download invoices for your records.</p>
                </div>
            </div>

            @if($payments->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                    <div class="h-16 w-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mb-6 border border-slate-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Payment History</h4>
                    <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">You haven't made any payments yet. When you purchase a package, the invoice will appear here.</p>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 overflow-hidden">
                    <ul class="divide-y divide-slate-100">
                        @foreach($payments as $payment)
                            <li class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1 flex flex-col md:flex-row md:items-center gap-4 md:gap-8">
                                    <div class="flex-shrink-0 h-12 w-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 border border-slate-100">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-sora font-bold text-slate-900 leading-tight">
                                            {{ $payment->order->package->name ?? 'Custom Package' }}
                                        </h4>
                                        <div class="flex items-center text-sm font-medium text-slate-500 mt-1 gap-2">
                                            <span>{{ $payment->created_at->format('M d, Y') }}</span>
                                            <span>&bull;</span>
                                            <span class="text-slate-400 font-mono text-xs">#{{ $payment->reference }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 flex items-center gap-6">
                                        <div class="text-right">
                                            <span class="block text-lg font-bold text-slate-900">${{ number_format($payment->amount, 2) }}</span>
                                            @if($payment->status === 'succeeded')
                                                <span class="inline-flex items-center text-xs font-bold text-emerald-600">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Paid
                                                </span>
                                            @else
                                                <span class="inline-flex items-center text-xs font-bold text-amber-600">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex-shrink-0 border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6">
                                    @if($payment->invoice)
                                        <a href="{{ route('invoices.show', $payment->invoice) }}" class="inline-flex justify-center items-center px-4 py-2 text-sm font-semibold rounded-xl text-brand-700 bg-brand-50 hover:bg-brand-100 hover:text-brand-800 transition-colors">
                                            View Receipt
                                        </a>
                                    @else
                                        <span class="inline-flex justify-center items-center px-4 py-2 text-sm font-semibold rounded-xl text-slate-400 bg-slate-50 cursor-not-allowed">
                                            Processing
                                        </span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
