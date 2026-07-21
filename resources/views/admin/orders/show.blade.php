<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('admin.orders.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h2 class="text-2xl font-bold text-slate-900">Order #{{ $order->reference }}</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-700 ring-1 ring-brand-200">
                    {{ optional($order->package)->name }}
                </span>
                @php
                    $statusColors = [
                        'submitted' => 'bg-amber-100 text-amber-800',
                        'in_progress' => 'bg-blue-100 text-blue-800',
                        'in_review' => 'bg-indigo-100 text-indigo-800',
                        'approved' => 'bg-purple-100 text-purple-800',
                        'delivered' => 'bg-emerald-100 text-emerald-800',
                    ];
                    $statusLabels = [
                        'submitted' => 'Submitted',
                        'in_progress' => 'In Progress',
                        'in_review' => 'Awaiting Review',
                        'approved' => 'Approved',
                        'delivered' => 'Delivered',
                    ];
                @endphp
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $statusLabels[$order->status] ?? ucwords(str_replace('_', ' ', $order->status)) }}
                </span>
                @php $daysOpen = $order->created_at->diffInDays(now()); @endphp
                @if($order->status !== 'delivered')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $daysOpen > 14 ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $daysOpen }} day{{ $daysOpen === 1 ? '' : 's' }} open
                    </span>
                @endif
            </div>
            <form action="{{ route('admin.orders.assign', $order) }}" method="POST" class="flex items-center gap-3">
                @csrf
                @method('PATCH')
                <label class="text-sm font-medium text-slate-600">Assigned To:</label>
                <select name="assigned_staff_id" class="text-sm border-slate-300 rounded-lg shadow-sm focus:ring-brand-500 focus:border-brand-500 py-1.5 pl-3 pr-8" onchange="this.form.submit()">
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

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        @php
            $totalPaid = $order->payments->where('status', 'success')->sum('amount');
            $currency = $order->payments->first()->currency ?? $order->package->currency ?? '';
        @endphp
        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Paid</p>
            <p class="mt-1.5 text-xl font-sora font-bold text-slate-900">{{ $currency }} {{ number_format($totalPaid, 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Deliverables</p>
            <p class="mt-1.5 text-xl font-sora font-bold text-slate-900">{{ $order->deliverables->where('is_current', true)->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Messages</p>
            <p class="mt-1.5 text-xl font-sora font-bold text-slate-900">{{ $order->messages->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Submitted</p>
            <p class="mt-1.5 text-xl font-sora font-bold text-slate-900">{{ $order->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- Progress Stepper -->
    <div class="bg-white rounded-2xl p-6 shadow-sm ring-1 ring-slate-200 mt-6">
        @php
            $steps = ['submitted' => 'Submitted', 'in_progress' => 'In Progress', 'in_review' => 'Awaiting Review', 'approved' => 'Approved', 'delivered' => 'Delivered'];
            $stepKeys = array_keys($steps);
            $currentIndex = array_search($order->status, $stepKeys);
        @endphp
        <div class="flex items-center">
            @foreach($steps as $key => $label)
                @php $stepIndex = array_search($key, $stepKeys); @endphp
                <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $stepIndex <= $currentIndex ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-400' }}">
                            @if($stepIndex < $currentIndex)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                {{ $stepIndex + 1 }}
                            @endif
                        </div>
                        <span class="mt-2 text-xs font-medium whitespace-nowrap {{ $stepIndex <= $currentIndex ? 'text-slate-900' : 'text-slate-400' }}">{{ $label }}</span>
                    </div>
                    @if(!$loop->last)
                        <div class="flex-1 h-0.5 mx-2 {{ $stepIndex < $currentIndex ? 'bg-brand-600' : 'bg-slate-100' }}"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-x-8 gap-y-8 mt-8">

        <!-- Left Column: Details & Deliverables & Notes -->
        <div class="xl:col-span-2 space-y-8">

            <!-- Client Info -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 6v-3a1 1 0 011-1h2a1 1 0 011 1v3"></path></svg>
                        Client & Business Info
                    </h3>
                    <a href="mailto:{{ $order->user->email }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-600 hover:text-brand-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Email Client
                    </a>
                </div>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
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

            <!-- Project Checklist / Deliverables -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8" x-data="{ openSlot: null }">
                @php
                    $typeBadgeColors = [
                        \App\Models\Deliverable::TYPE_LOGO => 'bg-purple-100 text-purple-700',
                        \App\Models\Deliverable::TYPE_BRAND_PDF => 'bg-indigo-100 text-indigo-700',
                        \App\Models\Deliverable::TYPE_BUSINESS_CARD => 'bg-pink-100 text-pink-700',
                        \App\Models\Deliverable::TYPE_LANDING_PAGE => 'bg-blue-100 text-blue-700',
                        \App\Models\Deliverable::TYPE_CAC_DOC => 'bg-amber-100 text-amber-700',
                        \App\Models\Deliverable::TYPE_SOCIAL_MEDIA => 'bg-cyan-100 text-cyan-700',
                        \App\Models\Deliverable::TYPE_CONTENT_PLAN => 'bg-teal-100 text-teal-700',
                        \App\Models\Deliverable::TYPE_BUSINESS_PROFILE => 'bg-lime-100 text-lime-700',
                        \App\Models\Deliverable::TYPE_OTHER => 'bg-slate-100 text-slate-600',
                    ];
                    $currentByType = $order->deliverables->where('is_current', true)->keyBy('type');
                    $pendingCount = $order->deliverables->where('is_current', true)->whereNull('sent_at')->count()
                        + ($order->website && is_null($order->website->sent_at) ? 1 : 0);
                @endphp

                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Project Checklist
                    </h3>
                    <form action="{{ route('admin.orders.send-to-founder', $order) }}" method="POST" onsubmit="return confirm('Send all completed deliverables to the founder now?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 transition-colors disabled:opacity-40 disabled:cursor-not-allowed" {{ $pendingCount === 0 ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            Send to Founder
                            @if($pendingCount > 0)
                                <span class="bg-white/20 rounded-full px-1.5 text-xs">{{ $pendingCount }}</span>
                            @endif
                        </button>
                    </form>
                </div>

                <ul class="divide-y divide-slate-100">
                    @foreach($checklist as $slotKey => $slot)
                        @if($slot['kind'] === 'file')
                            @php $deliverable = $currentByType->get($slot['type']); @endphp
                            <li class="py-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if($deliverable)
                                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @else
                                            <svg class="w-5 h-5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"></circle></svg>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-slate-900 flex items-center flex-wrap gap-1.5">
                                                {{ $slot['label'] }}
                                                @if($deliverable)
                                                    @if($deliverable->sent_at)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700">Sent</span>
                                                        @if($deliverable->approved_at)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-brand-100 text-brand-700">Approved</span>
                                                        @endif
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-600">Draft</span>
                                                    @endif
                                                @endif
                                            </p>
                                            @if($deliverable)
                                                <p class="text-xs text-slate-500 truncate">{{ $deliverable->title }} &middot; uploaded {{ $deliverable->created_at->format('M d, Y') }}</p>
                                            @else
                                                <p class="text-xs text-slate-400">Not uploaded yet</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 flex-shrink-0">
                                        @if($deliverable)
                                            <a href="{{ Storage::url($deliverable->file_path) }}" download class="text-sm font-medium text-brand-600 hover:text-brand-800">Download</a>
                                        @endif
                                        <button type="button" @click="openSlot = openSlot === '{{ $slotKey }}' ? null : '{{ $slotKey }}'" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                                            {{ $deliverable ? 'Replace' : 'Upload' }}
                                        </button>
                                        @if($deliverable)
                                            <form action="{{ route('admin.orders.deliverables.destroy', [$order, $deliverable]) }}" method="POST" onsubmit="return confirm('Remove this deliverable? This cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Remove</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div x-show="openSlot === '{{ $slotKey }}'" x-cloak class="mt-4 bg-slate-50 rounded-xl p-4 border border-slate-100">
                                    <form action="{{ route('admin.orders.deliverables.store', $order) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3 items-end">
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $slot['type'] }}">
                                        <div class="flex-1 w-full">
                                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Title</label>
                                            <input type="text" name="title" required value="{{ $slot['label'] }}" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                        </div>
                                        <div class="flex-1 w-full">
                                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">File</label>
                                            <input type="file" name="file" required class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-white file:text-slate-700 hover:file:bg-slate-100 border border-slate-200 rounded-lg transition">
                                        </div>
                                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                            Upload
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @elseif($slot['kind'] === 'website')
                            @php $website = $order->website; @endphp
                            <li class="py-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if($website && $website->status === 'live')
                                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @else
                                            <svg class="w-5 h-5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"></circle></svg>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-slate-900 flex items-center flex-wrap gap-1.5">
                                                Website
                                                @if($website)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-700">{{ ucwords(str_replace('_', ' ', $website->status)) }}</span>
                                                    @if($website->sent_at)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700">Sent</span>
                                                    @endif
                                                @endif
                                            </p>
                                            <p class="text-xs text-slate-500 truncate">{{ $website?->url ?? 'No URL set yet' }}</p>
                                        </div>
                                    </div>
                                    <button type="button" @click="openSlot = openSlot === 'website' ? null : 'website'" class="text-sm font-medium text-slate-600 hover:text-slate-900 flex-shrink-0">
                                        Manage
                                    </button>
                                </div>
                                <div x-show="openSlot === 'website'" x-cloak class="mt-4 bg-slate-50 rounded-xl p-4 border border-slate-100">
                                    <form action="{{ route('admin.orders.website.manage', $order) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @csrf
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Website URL</label>
                                            <input type="text" name="url" value="{{ $website?->url }}" placeholder="https://johncompany.com" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Status</label>
                                            <select name="status" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                                <option value="draft" @selected(($website?->status ?? 'draft') === 'draft')>Draft</option>
                                                <option value="in_progress" @selected($website?->status === 'in_progress')>In Progress</option>
                                                <option value="live" @selected($website?->status === 'live')>Ready / Live</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Hosting</label>
                                            <input type="text" name="hosting_type" value="{{ $website?->hosting?->hosting_type }}" placeholder="e.g. Connected" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Admin Login <span class="normal-case font-normal text-slate-400">(optional, stored encrypted)</span></label>
                                            <input type="text" name="admin_login" placeholder="e.g. admin / (leave blank to keep unchanged)" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                        </div>
                                        <button type="submit" class="sm:col-span-2 w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                            Save Website
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @elseif($slot['kind'] === 'domain')
                            @php $domain = $order->website?->domain; @endphp
                            <li class="py-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if($domain?->domain_name)
                                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @else
                                            <svg class="w-5 h-5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"></circle></svg>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-slate-900">Domain</p>
                                            <p class="text-xs text-slate-500 truncate">{{ $domain?->domain_name ?? 'Not connected yet' }}</p>
                                        </div>
                                    </div>
                                    <button type="button" @click="openSlot = openSlot === 'website' ? null : 'website'" class="text-sm font-medium text-slate-600 hover:text-slate-900 flex-shrink-0">
                                        Connect
                                    </button>
                                </div>
                                <div x-show="openSlot === 'website'" x-cloak class="mt-4 bg-slate-50 rounded-xl p-4 border border-slate-100">
                                    <form action="{{ route('admin.orders.website.manage', $order) }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-end">
                                        @csrf
                                        <input type="hidden" name="url" value="{{ $order->website?->url }}">
                                        <input type="hidden" name="status" value="{{ $order->website?->status ?? 'draft' }}">
                                        <div class="flex-1 w-full">
                                            <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Domain Name</label>
                                            <input type="text" name="domain_name" value="{{ $domain?->domain_name }}" placeholder="e.g. johncompany.com" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                        </div>
                                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                            Save Domain
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>

                <!-- Other / miscellaneous deliverables not on the standard checklist -->
                @php
                    $slotTypes = collect($checklist)->pluck('type')->filter()->all();
                    $otherDeliverables = $order->deliverables->where('is_current', true)->whereNotIn('type', $slotTypes);
                @endphp
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <button type="button" @click="openSlot = openSlot === 'other' ? null : 'other'" class="text-sm font-medium text-slate-500 hover:text-slate-900 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Add Other File
                    </button>
                    <div x-show="openSlot === 'other'" x-cloak class="mt-4 bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <form action="{{ route('admin.orders.deliverables.store', $order) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3 items-end">
                            @csrf
                            <input type="hidden" name="type" value="{{ \App\Models\Deliverable::TYPE_OTHER }}">
                            <div class="flex-1 w-full">
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Title</label>
                                <input type="text" name="title" required placeholder="e.g. Extra Asset" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            </div>
                            <div class="flex-1 w-full">
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">File</label>
                                <input type="file" name="file" required class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-white file:text-slate-700 hover:file:bg-slate-100 border border-slate-200 rounded-lg transition">
                            </div>
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-semibold rounded-lg shadow-sm text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                Upload
                            </button>
                        </form>
                    </div>

                    @if($otherDeliverables->isNotEmpty())
                        <ul class="mt-4 divide-y divide-slate-100">
                            @foreach($otherDeliverables as $deliverable)
                                <li class="py-3 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $typeBadgeColors[$deliverable->type] ?? 'bg-slate-100 text-slate-600' }}">{{ ucwords(str_replace('_', ' ', $deliverable->type)) }}</span>
                                        <span class="text-sm text-slate-800 truncate">{{ $deliverable->title }}</span>
                                        @if($deliverable->sent_at)
                                            <span class="text-xs text-emerald-600 font-medium">Sent</span>
                                        @else
                                            <span class="text-xs text-slate-400">Draft</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 flex-shrink-0">
                                        <a href="{{ Storage::url($deliverable->file_path) }}" download class="text-sm font-medium text-brand-600 hover:text-brand-800">Download</a>
                                        <form action="{{ route('admin.orders.deliverables.destroy', [$order, $deliverable]) }}" method="POST" onsubmit="return confirm('Remove this deliverable? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Remove</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Client Messages -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Messages
                    <span class="text-slate-400 font-normal text-sm">(Visible to Client)</span>
                </h3>

                @if($order->messages->isEmpty())
                    <p class="text-sm text-slate-500 mb-6">No messages yet.</p>
                @else
                    <ul class="space-y-4 mb-6 max-h-96 overflow-y-auto pr-1">
                        @foreach($order->messages as $message)
                            <li class="flex {{ $message->user_id === $order->user_id ? 'justify-start' : 'justify-end' }}">
                                <div class="max-w-md rounded-2xl px-4 py-3 {{ $message->user_id === $order->user_id ? 'bg-slate-100 text-slate-800' : 'bg-brand-600 text-white' }}">
                                    <p class="text-sm whitespace-pre-wrap">{{ $message->body }}</p>
                                    <p class="mt-1 text-xs {{ $message->user_id === $order->user_id ? 'text-slate-500' : 'text-brand-100' }}">
                                        {{ $message->user->name }} &middot; {{ $message->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ route('admin.orders.messages.store', $order) }}" method="POST">
                    @csrf
                    <textarea name="body" rows="2" required class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="Reply to the client..."></textarea>
                    <div class="mt-3">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                            Send Message
                        </button>
                    </div>
                    @error('body') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </form>
            </div>

            <!-- Internal Notes -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path></svg>
                    Internal Notes
                    <span class="text-slate-400 font-normal text-sm">(Hidden from Client)</span>
                </h3>

                <div class="mb-8">
                    <form action="{{ route('admin.orders.notes.store', $order) }}" method="POST">
                        @csrf
                        <textarea name="note" rows="2" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm" placeholder="Add a private note about this order..." required></textarea>
                        <div class="mt-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition-colors">
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
        <div class="space-y-8">

            <!-- Update Status -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-100 pb-4 mb-6">Manage Status</h3>
                <form action="{{ route('admin.orders.status.update', $order) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Current Status</label>
                        <select name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-slate-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm rounded-lg shadow-sm">
                            <option value="submitted" {{ $order->status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="in_review" {{ $order->status === 'in_review' ? 'selected' : '' }}>Awaiting Review</option>
                            <option value="approved" {{ $order->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Client-facing Notes <span class="text-slate-400 font-normal text-xs ml-1">(Optional)</span></label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="Any updates for the client..."></textarea>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 transition">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Payment Lookups -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-100 pb-4 mb-6">Payments</h3>
                @if($order->payments->isEmpty())
                    <p class="text-sm text-slate-500">No payment records found.</p>
                @else
                    <ul class="space-y-4">
                        @foreach($order->payments as $payment)
                            <li class="pb-4 border-b border-slate-100 last:border-0 last:pb-0">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ $payment->status === 'success' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ strtoupper($payment->status) }}</span>
                                    <span class="text-sm font-semibold text-slate-900">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs text-slate-500">
                                    <span>{{ $payment->provider }} &middot; {{ $payment->provider_reference }}</span>
                                    <span>{{ $payment->created_at->format('M d, Y') }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Status Timeline -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-100 pb-4 mb-6">Status History</h3>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($order->statusLogs()->latest()->get() as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-3 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-4 items-start">
                                        <div>
                                            <span class="h-6 w-6 rounded-full {{ $statusColors[$log->to_status] ?? 'bg-slate-50 text-slate-400' }} border border-slate-200 flex items-center justify-center">
                                                <div class="h-1.5 w-1.5 rounded-full bg-current"></div>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-0.5">
                                            <div class="flex justify-between">
                                                <p class="text-sm font-medium text-slate-900">{{ $statusLabels[$log->to_status] ?? ucwords(str_replace('_', ' ', $log->to_status)) }}</p>
                                                <time class="text-xs text-slate-400 whitespace-nowrap" datetime="{{ $log->created_at }}">{{ $log->created_at->format('M d, Y') }}</time>
                                            </div>
                                            @if($log->note)
                                                <p class="mt-1 text-sm text-slate-600">"{{ $log->note }}"</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <p class="text-sm text-slate-500">No status changes recorded yet.</p>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
