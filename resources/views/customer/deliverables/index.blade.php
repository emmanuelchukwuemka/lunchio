<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Assets & Files Hub') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h3 class="text-xl font-sora font-bold text-slate-900">Your Deliverables</h3>
                    <p class="text-slate-500 mt-1">Download and manage the files, designs, and code we've delivered for your launches.</p>
                </div>
            </div>

            @if($deliverables->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                    <div class="h-16 w-16 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center mb-6 border border-brand-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Assets Yet</h4>
                    <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">Our team is still working on your launches. Your deliverables will appear here once they are ready.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($deliverables as $asset)
                        <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl ring-1 ring-slate-200/60 overflow-hidden transform hover:-translate-y-1 transition-all duration-300 flex flex-col group">
                            <!-- Top colored accent -->
                            <div class="h-2 bg-gradient-to-r from-brand-500 to-indigo-500"></div>
                            
                            <div class="p-8 flex-1">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="h-12 w-12 bg-brand-50 rounded-2xl flex items-center justify-center text-brand-600 mb-4 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500">
                                        {{ $asset->order->package->name }}
                                    </span>
                                </div>
                                
                                <h4 class="text-lg font-sora font-bold text-slate-900 leading-tight mb-2">{{ $asset->title }}</h4>
                                <p class="text-sm text-slate-500 line-clamp-2">{{ $asset->description }}</p>
                                
                                <div class="mt-6 pt-6 border-t border-slate-100">
                                    <div class="flex items-center justify-between text-xs font-semibold">
                                        <span class="text-slate-400">Added {{ $asset->created_at->format('M d, Y') }}</span>
                                        @if($asset->status === 'approved')
                                            <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">Approved</span>
                                        @else
                                            <span class="text-amber-600 bg-amber-50 px-2 py-1 rounded-md">Pending Review</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-slate-50 border-t border-slate-100 flex gap-3">
                                @if($asset->file_url)
                                    <a href="{{ $asset->file_url }}" target="_blank" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download
                                    </a>
                                @endif
                                <a href="{{ route('orders.show', $asset->order_id) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-slate-700 bg-white border border-slate-200 hover:bg-slate-100 transition-colors shadow-sm">
                                    View Launch
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
