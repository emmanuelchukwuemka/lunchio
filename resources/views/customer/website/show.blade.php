<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
                {{ $website->name ?? 'My Website' }}
            </h2>
            @if($website->approved_at)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-current mr-2"></span>
                    Approved
                </span>
            @elseif($website->status === 'live')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800 border border-blue-200">
                    <span class="w-2 h-2 rounded-full bg-current mr-2"></span>
                    Live &mdash; Awaiting Your Approval
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-amber-100 text-amber-800 border border-amber-200">
                    <span class="w-2 h-2 rounded-full bg-current mr-2"></span>
                    Building
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- Status Banner -->
        <div class="bg-gradient-to-r from-indigo-900 to-brand-800 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full filter blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    @if($website->status === 'live')
                        <h3 class="text-2xl font-sora font-bold mb-2">Your website is live! 🎉</h3>
                        <p class="text-brand-100 max-w-2xl text-lg">Your site is published. Need something changed? Just let us know.</p>
                    @else
                        <h3 class="text-2xl font-sora font-bold mb-2">Your website is being built! 🚀</h3>
                        <p class="text-brand-100 max-w-2xl text-lg">Our team is configuring your pages, applying your theme, and integrating your chosen features.</p>
                    @endif
                </div>
                <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                    @php $siteUrl = $website->url ?? ($website->domain?->domain_name ? 'https://'.$website->domain->domain_name : null); @endphp
                    @if($website->status === 'live' && $siteUrl)
                        <a href="{{ $siteUrl }}" target="_blank" class="inline-flex items-center justify-center px-5 py-3 bg-white text-brand-800 rounded-xl text-sm font-semibold hover:bg-brand-50 transition-colors shadow-sm">
                            Visit Website &rarr;
                        </a>
                    @else
                        <span class="inline-flex items-center justify-center px-5 py-3 bg-white/10 text-white/70 rounded-xl text-sm font-semibold border border-white/20">
                            Not Live Yet
                        </span>
                    @endif
                    @unless($website->approved_at)
                        <form action="{{ route('websites.approve', $website) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center px-5 py-3 bg-emerald-500 text-white rounded-xl text-sm font-semibold hover:bg-emerald-400 transition-colors shadow-sm w-full">
                                Approve Website
                            </button>
                        </form>
                    @endunless
                    @if($latestOrder)
                        <a href="{{ route('orders.show', $latestOrder) }}#messages" class="inline-flex items-center justify-center px-5 py-3 bg-white/10 text-white rounded-xl text-sm font-semibold border border-white/20 hover:bg-white/20 transition-colors">
                            Request Changes
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Details Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- General Info -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-xl font-sora font-bold text-slate-900 mb-6">Website Details</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-slate-500">Business Name</dt>
                            <dd class="mt-1 text-lg font-semibold text-slate-900">{{ $website->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500">Industry</dt>
                            <dd class="mt-1 text-lg font-semibold text-slate-900">{{ $website->industry ?? 'N/A' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-slate-500">Tagline</dt>
                            <dd class="mt-1 text-base text-slate-900">{{ $website->tagline ?? 'N/A' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-slate-500">Description</dt>
                            <dd class="mt-1 text-base text-slate-900">{{ $website->description ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Theme & Branding -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-xl font-sora font-bold text-slate-900 mb-6">Theme & Branding</h3>
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1 w-full">
                            <p class="text-sm font-medium text-slate-500 mb-2">Selected Theme</p>
                            <div class="p-4 rounded-xl border border-indigo-100 bg-indigo-50 font-semibold text-indigo-900 text-lg">
                                {{ $website->theme ?? 'Launchio Standard' }}
                            </div>
                        </div>
                        @if($website->branding)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full shadow-inner ring-1 ring-black/10" style="background-color: {{ $website->branding->primary_color }}"></div>
                                <span class="text-xs text-slate-500 mt-2 font-mono">{{ $website->branding->primary_color }}</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full shadow-inner ring-1 ring-black/10" style="background-color: {{ $website->branding->secondary_color }}"></div>
                                <span class="text-xs text-slate-500 mt-2 font-mono">{{ $website->branding->secondary_color }}</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full shadow-inner ring-1 ring-black/10" style="background-color: {{ $website->branding->accent_color }}"></div>
                                <span class="text-xs text-slate-500 mt-2 font-mono">{{ $website->branding->accent_color }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Pages & Features -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                        <h3 class="text-xl font-sora font-bold text-slate-900 mb-6">Pages Requested</h3>
                        <ul class="space-y-3">
                            @forelse($website->pages as $page)
                                <li class="flex items-center text-slate-700">
                                    <svg class="w-5 h-5 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $page->name }}
                                </li>
                            @empty
                                <li class="text-slate-500 italic">No standard pages selected.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                        <h3 class="text-xl font-sora font-bold text-slate-900 mb-6">Features Enabled</h3>
                        <ul class="space-y-3">
                            @forelse($website->features as $feature)
                                <li class="flex items-center text-slate-700">
                                    <svg class="w-5 h-5 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    {{ $feature->feature_name }}
                                </li>
                            @empty
                                <li class="text-slate-500 italic">No specific features selected.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Sidebar Column -->
            <div class="space-y-8">
                <!-- Domain Info -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-lg font-sora font-bold text-slate-900 mb-4">Domain</h3>
                    @if($website->domain)
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $website->domain->domain_name ?? 'Pending Registration' }}</p>
                                <p class="text-xs text-slate-500">{{ ucfirst($website->domain->type) }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-slate-500">Domain setup pending or using Launchio subdomain.</p>
                    @endif
                </div>

                <!-- Hosting Info -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-lg font-sora font-bold text-slate-900 mb-4">Hosting</h3>
                    @if($website->hosting)
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ ucfirst($website->hosting->hosting_type) }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-slate-500">Launchio managed hosting.</p>
                    @endif
                </div>

                <!-- AI Prompt (If any) -->
                @if($website->ai_prompt)
                <div class="bg-slate-900 rounded-3xl shadow-sm p-8 text-white relative overflow-hidden">
                    <svg class="absolute top-4 right-4 w-12 h-12 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <h3 class="text-lg font-sora font-bold mb-4 relative z-10">AI Directive</h3>
                    <p class="text-sm text-slate-300 italic relative z-10">"{{ $website->ai_prompt }}"</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
