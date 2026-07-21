<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-900">{{ $website->name ?? 'Untitled Website' }}</h2>
            <span class="text-sm text-slate-500">Submitted by {{ $website->user?->name ?? '—' }}</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-x-16 gap-y-16 mt-6">
        <!-- Left: Requirements (read-only, submitted by founder) -->
        <div class="xl:col-span-2 space-y-16">
            <div>
                <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Requirements Submitted</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Type</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $website->type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Industry</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $website->industry ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Tagline</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $website->tagline ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Description</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $website->description ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Theme</dt>
                        <dd class="mt-1 text-sm text-slate-900">{{ $website->theme ?? 'N/A' }}</dd>
                    </div>
                    @if($website->ai_prompt)
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-slate-500">AI Directive</dt>
                            <dd class="mt-1 text-sm text-slate-900 italic">"{{ $website->ai_prompt }}"</dd>
                        </div>
                    @endif
                </dl>

                @if($website->branding)
                    <div class="mt-8">
                        <p class="text-sm font-medium text-slate-500 mb-3">Brand Colors</p>
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full ring-1 ring-black/10" style="background-color: {{ $website->branding->primary_color }}"></div>
                                <span class="text-xs text-slate-500 mt-1 font-mono">{{ $website->branding->primary_color }}</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full ring-1 ring-black/10" style="background-color: {{ $website->branding->secondary_color }}"></div>
                                <span class="text-xs text-slate-500 mt-1 font-mono">{{ $website->branding->secondary_color }}</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full ring-1 ring-black/10" style="background-color: {{ $website->branding->accent_color }}"></div>
                                <span class="text-xs text-slate-500 mt-1 font-mono">{{ $website->branding->accent_color }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Pages Requested</h3>
                    <ul class="space-y-2">
                        @forelse($website->pages as $page)
                            <li class="text-sm text-slate-700">{{ $page->name }}</li>
                        @empty
                            <li class="text-sm text-slate-400 italic">None specified</li>
                        @endforelse
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-3 mb-6">Features Requested</h3>
                    <ul class="space-y-2">
                        @forelse($website->features as $feature)
                            <li class="text-sm text-slate-700">{{ $feature->feature_name }}</li>
                        @empty
                            <li class="text-sm text-slate-400 italic">None specified</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right: Admin actions -->
        <div class="space-y-16">
            <div>
                <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900">Deliver Website</h3>
                    @if($website->sent_at)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Sent to Founder</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Draft</span>
                    @endif
                </div>

                @if($website->order)
                    <p class="text-xs text-slate-500 mb-6">
                        Tied to <a href="{{ route('admin.orders.show', $website->order) }}" class="text-brand-600 hover:text-brand-800 font-medium">Order #{{ $website->order->reference }}</a>.
                        Files (logo, brand kit, etc.) for this project are uploaded and sent from there &mdash; this page is just for the website's own delivery details.
                    </p>
                @endif

                <form action="{{ route('admin.websites.update', $website) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Website URL</label>
                        <input type="text" name="url" value="{{ $website->url }}" placeholder="https://johncompany.com" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                            <option value="draft" @selected($website->status === 'draft')>Draft</option>
                            <option value="in_progress" @selected($website->status === 'in_progress')>In Progress</option>
                            <option value="live" @selected($website->status === 'live')>Ready / Live</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Domain</label>
                        <input type="text" name="domain_name" value="{{ $website->domain?->domain_name }}" placeholder="e.g. mybusiness.com" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                        <p class="text-xs text-slate-400 mt-1">Requested type: {{ $website->domain?->type ?? 'not specified' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Hosting</label>
                        <input type="text" name="hosting_type" value="{{ $website->hosting?->hosting_type }}" placeholder="e.g. launchio" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Admin Login <span class="text-slate-400 font-normal text-xs">(optional, stored encrypted)</span></label>
                        <input type="text" name="admin_login" placeholder="{{ $website->admin_login ? 'Set — leave blank to keep unchanged' : 'e.g. admin / password' }}" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 transition">
                        Save
                    </button>
                </form>

                @if($website->order && is_null($website->sent_at))
                    <form action="{{ route('admin.orders.send-to-founder', $website->order) }}" method="POST" class="mt-4" onsubmit="return confirm('Send all completed deliverables (including this website) to the founder now?');">
                        @csrf
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition">
                            Send to Founder
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
