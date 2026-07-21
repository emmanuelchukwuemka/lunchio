@props(['categories', 'emptyTitle' => 'No Assets Yet', 'emptyText' => 'Your deliverables will appear here once they are ready.'])

@php $allEmpty = collect($categories)->every(fn ($items) => $items->isEmpty()); @endphp

<div x-data="{ tab: '{{ array_key_first($categories) }}' }">
    @if($allEmpty)
        <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
            <div class="h-16 w-16 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center mb-6 border border-brand-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            </div>
            <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">{{ $emptyTitle }}</h4>
            <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">{{ $emptyText }}</p>
        </div>
    @else
        <div class="flex gap-2 border-b border-slate-200">
            @foreach($categories as $label => $items)
                <button type="button" @click="tab = '{{ $label }}'"
                    :class="tab === '{{ $label }}' ? 'border-brand-600 text-brand-700' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors">
                    {{ $label }} <span class="ml-1 text-xs text-slate-400">({{ $items->count() }})</span>
                </button>
            @endforeach
        </div>

        @foreach($categories as $label => $items)
            <div x-show="tab === '{{ $label }}'" x-cloak>
                @if($items->isEmpty())
                    <p class="text-sm text-slate-400 italic py-8 text-center">No {{ strtolower($label) }} delivered yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        @foreach($items as $asset)
                            <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl ring-1 ring-slate-200/60 overflow-hidden transform hover:-translate-y-1 transition-all duration-300 flex flex-col group" x-data="{ requesting: false }">
                                <div class="h-2 bg-gradient-to-r from-brand-500 to-indigo-500"></div>

                                <div class="p-8 flex-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="h-12 w-12 bg-brand-50 rounded-2xl flex items-center justify-center text-brand-600 mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        @if($asset->approved_at)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700">Approved</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500">
                                                {{ $asset->order->package->name ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </div>

                                    <h4 class="text-lg font-sora font-bold text-slate-900 leading-tight mb-2">{{ $asset->title }}</h4>
                                    @if($asset->notes)
                                        <p class="text-sm text-slate-500 line-clamp-2">{{ $asset->notes }}</p>
                                    @endif

                                    <div class="mt-6 pt-6 border-t border-slate-100">
                                        <div class="flex items-center justify-between text-xs font-semibold">
                                            <span class="text-slate-400">Added {{ $asset->created_at->format('M d, Y') }}</span>
                                            <span class="text-slate-500 bg-slate-100 px-2 py-1 rounded-md">v{{ $asset->version }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 bg-slate-50 border-t border-slate-100 flex flex-col gap-3">
                                    <div class="flex gap-3">
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($asset->file_path) }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Download
                                        </a>
                                        <a href="{{ route('orders.show', $asset->order_id) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-slate-700 bg-white border border-slate-200 hover:bg-slate-100 transition-colors shadow-sm">
                                            View Launch
                                        </a>
                                    </div>
                                    @unless($asset->approved_at)
                                        <div class="flex gap-3">
                                            <form action="{{ route('deliverables.approve', $asset) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-semibold rounded-xl text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                                    Approve
                                                </button>
                                            </form>
                                            <button type="button" @click="requesting = !requesting" class="flex-1 inline-flex justify-center items-center px-4 py-2 text-sm font-semibold rounded-xl text-amber-700 bg-amber-50 hover:bg-amber-100 transition-colors">
                                                Request Changes
                                            </button>
                                        </div>
                                        <form x-show="requesting" x-cloak action="{{ route('deliverables.revision', $asset) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            <textarea name="revision_notes" rows="2" required placeholder="What needs to change?" class="text-sm rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500"></textarea>
                                            <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-medium rounded-md hover:bg-slate-800 transition self-start">Submit Request</button>
                                        </form>
                                    @endunless
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
