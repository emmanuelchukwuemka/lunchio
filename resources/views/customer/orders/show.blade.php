<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-brand-900 leading-tight">
                {{ $order->package->name }} - <span class="text-gray-500">{{ $order->business_name }}</span>
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-brand-100 text-brand-800">
                Order #{{ $order->reference }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Status Tracker -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Launch Status</h3>
                
                <div class="relative">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-100">
                        @php
                            $progress = match($order->status) {
                                'submitted' => 20,
                                'in_progress' => 50,
                                'in_review' => 75,
                                'approved' => 90,
                                'delivered' => 100,
                                default => 0,
                            };
                        @endphp
                        <div style="width: {{ $progress }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-brand-500 transition-all duration-500"></div>
                    </div>
                    <div class="flex justify-between text-xs font-semibold text-gray-400">
                        <span class="{{ $progress >= 20 ? 'text-brand-600' : '' }}">Submitted</span>
                        <span class="{{ $progress >= 50 ? 'text-brand-600' : '' }}">In Progress</span>
                        <span class="{{ $progress >= 75 ? 'text-brand-600' : '' }}">In Review</span>
                        <span class="{{ $progress >= 100 ? 'text-brand-600' : '' }}">Delivered</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Main Content / Deliverables -->
                <div class="md:col-span-2 space-y-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deliverables Vault</h3>
                        
                        @if($order->deliverables->isEmpty())
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-gray-500">No deliverables have been uploaded yet.<br>Our team is working on your assets.</p>
                            </div>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($order->deliverables()->where('is_current', true)->orderByDesc('created_at')->get() as $deliverable)
                                    <li class="py-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <div class="flex items-center">
                                                <svg class="h-8 w-8 text-brand-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $deliverable->title }}
                                                        @if($deliverable->version > 1)
                                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">v{{ $deliverable->version }}</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-500">Uploaded on {{ $deliverable->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <a href="{{ Storage::url($deliverable->file_path) }}" download class="text-sm font-medium text-brand-600 hover:text-brand-500">Download</a>
                                            </div>
                                        </div>

                                        <!-- Request Revision Form -->
                                        <div class="mt-4 pl-11">
                                            <details class="text-sm group">
                                                <summary class="cursor-pointer text-gray-500 hover:text-brand-600 font-medium list-none">
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                        Request Revision
                                                    </span>
                                                </summary>
                                                <form action="{{ route('deliverables.revision', $deliverable) }}" method="POST" class="mt-3 bg-gray-50 p-4 rounded-md border border-gray-100">
                                                    @csrf
                                                    <label class="block text-xs font-medium text-gray-700 mb-1">What needs to be changed?</label>
                                                    <textarea name="revision_notes" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" required placeholder="Please describe the edits needed..."></textarea>
                                                    <div class="mt-3 flex justify-end">
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-brand-600 hover:bg-brand-700">
                                                            Submit Request
                                                        </button>
                                                    </div>
                                                </form>
                                            </details>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Sidebar / Business Summary -->
                <div class="space-y-8">
                    <div class="bg-gray-50 overflow-hidden sm:rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Business Profile</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-xs text-gray-500">Industry</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $order->industry ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Stage</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $order->business_stage ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Target Location</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $order->location ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
