<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Upgrade Package') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <p class="text-slate-500">
                Currently on <strong class="text-slate-800">{{ $currentPackage?->name ?? 'no package' }}</strong>. Request an upgrade and your Launchio team will follow up on payment and next steps.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($allPackages as $package)
                    @php $isCurrent = $currentPackage && $package->id === $currentPackage->id; @endphp
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 flex flex-col {{ $isCurrent ? 'ring-2 ring-brand-500' : '' }}">
                        <h3 class="font-semibold text-slate-900">{{ $package->name }}</h3>
                        <p class="text-sm text-slate-500 mt-1 flex-1">{{ $package->tagline }}</p>
                        <p class="text-2xl font-sora font-bold text-slate-900 mt-4">{{ $package->currency }} {{ number_format($package->price_one_time, 0) }}</p>

                        @if($isCurrent)
                            <span class="mt-6 inline-flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-500 rounded-xl text-sm font-semibold">Current Package</span>
                        @else
                            <form action="{{ route('package.upgrade.request', $package) }}" method="POST" class="mt-6">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
                                    Request Upgrade
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
