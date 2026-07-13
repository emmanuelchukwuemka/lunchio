<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-slate-900 flex items-center">
                Order #{{ $order->reference }}
                <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-brand-50 text-brand-700">
                    {{ optional($order->package)->name }}
                </span>
            </h2>
            <form action="{{ route('admin.orders.assign', $order) }}" method="POST" class="flex items-center gap-3">
                @csrf
                @method('PATCH')
                <label class="text-sm font-medium text-slate-600">Assigned To:</label>
                <select name="assigned_staff_id" class="text-sm border-slate-300 rounded-md shadow-sm focus:ring-brand-500 focus:border-brand-500 py-1.5 pl-3 pr-8" onchange="this.form.submit()">
                    <option value="">Unassigned</option>
                    @foreach($staffMembers as $staff)
                        <option value="{{ $staff->id }}" {{ $order->assigned_staff_id === $staff->id ? 'selected' : '' }}>
                            {{ $staff->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-x-16 gap-y-16 mt-6">
        
        <!-- Left Column: Details & Deliverables & Notes -->
        <div class="xl:col-span-2 space-y-16">
            
            <!-- Client Info -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Client & Business Info</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500">Client Name</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->user->name }} <span class="text-slate-500">({{ $order->user->email }})</span></dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500">Business Name</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->business_name }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Business Description</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->business_description ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500">Industry / Stage</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->industry }} &mdash; {{ $order->business_stage }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-slate-500">Target Location</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->location ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Target Audience</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $order->target_audience ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Deliverables -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Deliverables</h3>
                <div class="mb-8">
                    <form action="{{ route('admin.orders.deliverables.store', $order) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4 items-end">
                        @csrf
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-medium text-slate-700">Deliverable Title (e.g. Logo Final)</label>
                            <input type="text" name="title" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                        </div>
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-medium text-slate-700">Upload File</label>
                            <input type="file" name="file" required class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100 border border-slate-200 transition">
                        </div>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md shadow-sm text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition-colors">
                            Upload
                        </button>
                    </form>
                    @error('file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                @if($order->deliverables->isEmpty())
                    <p class="text-sm text-slate-500">No deliverables uploaded yet.</p>
                @else
                    <ul class="divide-y divide-slate-100 border-t border-slate-100">
                        @foreach($order->deliverables()->orderByDesc('created_at')->get() as $deliverable)
                            <li class="py-4 flex justify-between items-center group">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">
                                            {{ $deliverable->title }}
                                            @if($deliverable->version > 1)
                                                <span class="ml-2 text-xs text-slate-500">v{{ $deliverable->version }}</span>
                                            @endif
                                            @if($deliverable->is_current)
                                                <span class="ml-2 text-xs text-brand-600 font-semibold">Current</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-slate-500 mt-0.5">Uploaded {{ $deliverable->created_at->format('M d, Y') }} by {{ optional($deliverable->uploader)->name ?? 'Staff' }}</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($deliverable->file_path) }}" download class="text-sm font-medium text-brand-600 hover:text-brand-800 transition opacity-0 group-hover:opacity-100 focus:opacity-100">Download</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Internal Notes -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Internal Notes <span class="text-slate-400 font-normal text-sm ml-2">(Hidden from Client)</span></h3>
                
                <div class="mb-8">
                    <form action="{{ route('admin.orders.notes.store', $order) }}" method="POST">
                        @csrf
                        <textarea name="note" rows="2" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm" placeholder="Add a private note about this order..." required></textarea>
                        <div class="mt-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition-colors">
                                Add Note
                            </button>
                        </div>
                    </form>
                </div>

                @if($order->adminNotes->isEmpty())
                    <p class="text-sm text-slate-500">No internal notes yet.</p>
                @else
                    <ul class="space-y-6 border-l-2 border-slate-100 pl-4">
                        @foreach($order->adminNotes()->latest()->get() as $note)
                            <li>
                                <div class="text-sm text-slate-800 whitespace-pre-wrap">{{ $note->note }}</div>
                                <div class="mt-2 text-xs font-medium text-slate-500">
                                    {{ $note->staff->name }} &middot; <span class="text-slate-400">{{ $note->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

        <!-- Right Column: Status, Logs, Payments -->
        <div class="space-y-16">
            
            <!-- Update Status -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Manage Status</h3>
                <form action="{{ route('admin.orders.status.update', $order) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Current Status</label>
                        <select name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-slate-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm rounded-md shadow-sm">
                            <option value="submitted" {{ $order->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="in_review" {{ $order->status === 'in_review' ? 'selected' : '' }}>In Review</option>
                            <option value="approved" {{ $order->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Client-facing Notes <span class="text-slate-400 font-normal text-xs ml-1">(Optional)</span></label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="Any updates for the client..."></textarea>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 transition">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Payment Lookups -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Payments</h3>
                @if($order->payments->isEmpty())
                    <p class="text-sm text-slate-500">No payment records found.</p>
                @else
                    <ul class="space-y-4">
                        @foreach($order->payments as $payment)
                            <li class="pb-4 border-b border-slate-100 last:border-0 last:pb-0">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium {{ $payment->status === 'successful' ? 'text-green-600' : 'text-red-600' }}">{{ strtoupper($payment->status) }}</span>
                                    <span class="text-sm font-semibold text-slate-900">₦{{ number_format($payment->amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs text-slate-500">
                                    <span>{{ $payment->gateway ?? $payment->provider }} &middot; {{ $payment->transaction_reference ?? $payment->provider_reference }}</span>
                                    <span>{{ $payment->created_at->format('M d, Y') }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Status Timeline -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Status History</h3>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($order->statusLogs()->latest()->get() as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-3 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-4 items-start">
                                        <div>
                                            <span class="h-6 w-6 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center">
                                                <div class="h-1.5 w-1.5 rounded-full bg-slate-400"></div>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-0.5">
                                            <div class="flex justify-between">
                                                <p class="text-sm font-medium text-slate-900">{{ ucwords(str_replace('_', ' ', $log->status)) }}</p>
                                                <time class="text-xs text-slate-400 whitespace-nowrap" datetime="{{ $log->created_at }}">{{ $log->created_at->format('M d, Y') }}</time>
                                            </div>
                                            @if($log->notes)
                                                <p class="mt-1 text-sm text-slate-600">"{{ $log->notes }}"</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
