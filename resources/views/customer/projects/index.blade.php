<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('My Projects') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="flex gap-2">
                <a href="{{ route('projects.index') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ !$bucket ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">All</a>
                <a href="{{ route('projects.index', ['bucket' => 'active']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $bucket === 'active' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">Active</a>
                <a href="{{ route('projects.index', ['bucket' => 'pending_review']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $bucket === 'pending_review' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">Pending Review</a>
                <a href="{{ route('projects.index', ['bucket' => 'completed']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $bucket === 'completed' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">Completed</a>
            </div>

            @if(empty($projects))
                <div class="flex flex-col items-center justify-center p-12 bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100">
                    <h4 class="text-xl font-sora font-bold text-slate-900 mb-2">No Projects Yet</h4>
                    <p class="text-slate-500 text-sm mb-6 text-center max-w-sm">Once you purchase a package, your Website, Branding, Registration, and Marketing projects will be tracked here.</p>
                    <a href="{{ route('intake') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                        Start a Launch
                    </a>
                </div>
            @else
                @php
                    $statusColors = [
                        'submitted' => 'bg-amber-100 text-amber-800 border-amber-200',
                        'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                        'in_review' => 'bg-purple-100 text-purple-800 border-purple-200',
                        'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                        'delivered' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                    ];
                    $categoryIcons = [
                        'Website' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'Branding' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485',
                        'Registration' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                        'Marketing' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z',
                    ];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($projects as $project)
                        @php $colorClass = $statusColors[$project['status']] ?? 'bg-slate-100 text-slate-800 border-slate-200'; @endphp
                        <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 border border-slate-100 p-8">
                            <div class="flex items-start justify-between mb-4">
                                <div class="h-12 w-12 bg-brand-50 rounded-2xl flex items-center justify-center text-brand-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $categoryIcons[$project['category']] }}"></path></svg>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
                                    {{ ucwords(str_replace('_', ' ', $project['status'])) }}
                                </span>
                            </div>
                            <h4 class="text-lg font-sora font-bold text-slate-900">{{ $project['category'] }}</h4>
                            <p class="text-sm text-slate-500 mt-1">{{ $project['order']->business_name }} &middot; {{ $project['order']->package->name ?? 'N/A' }}</p>

                            @if($project['category'] === 'Website')
                                @if($project['website']?->sent_at)
                                    <ul class="mt-4 space-y-2">
                                        <li class="text-sm text-slate-700 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            {{ $project['website']->url ?? $project['website']->name }}
                                        </li>
                                    </ul>
                                @else
                                    <p class="text-sm text-slate-400 mt-4 italic">Not delivered yet.</p>
                                @endif
                            @elseif($project['deliverables']->isNotEmpty())
                                <ul class="mt-4 space-y-2">
                                    @foreach($project['deliverables'] as $deliverable)
                                        <li class="text-sm text-slate-700 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            {{ $deliverable->title }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-slate-400 mt-4 italic">Not delivered yet.</p>
                            @endif

                            <div class="mt-6 pt-6 border-t border-slate-100">
                                <a href="{{ route('orders.show', $project['order']) }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700">
                                    View Launch &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
