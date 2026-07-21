<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Hire Experts') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ booking: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div>
                <h3 class="text-xl font-sora font-bold text-slate-900">Available Experts</h3>
                <p class="text-slate-500 mt-1">Book a paid consultation with a vetted specialist for anything outside your package.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($experts as $expert)
                    <div class="bg-white rounded-3xl shadow-sm ring-1 ring-slate-200/60 p-8">
                        <h4 class="text-lg font-sora font-bold text-slate-900">{{ $expert->name }}</h4>
                        <p class="text-sm font-medium text-brand-600 mt-1">{{ $expert->specialty }}</p>
                        <p class="text-sm text-slate-500 mt-3">{{ $expert->bio }}</p>

                        <button type="button" @click="booking = booking === {{ $expert->id }} ? null : {{ $expert->id }}" class="mt-6 w-full inline-flex justify-center items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                            <span x-text="booking === {{ $expert->id }} ? 'Cancel' : 'Request Booking'"></span>
                        </button>

                        <form x-show="booking === {{ $expert->id }}" x-cloak action="{{ route('experts.book', $expert) }}" method="POST" class="mt-4 flex flex-col gap-3">
                            @csrf
                            <textarea name="message" rows="2" required placeholder="What do you need help with?" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500"></textarea>
                            <input type="datetime-local" name="scheduled_at" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                            <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-md hover:bg-slate-800 transition">Send Request</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 col-span-full text-center py-12">No experts available right now.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-semibold text-slate-900">Your Bookings</h3>
                </div>
                <ul class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <li class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-slate-900">{{ $booking->expert->name }}</p>
                                <p class="text-sm text-slate-500">{{ $booking->message }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-amber-100 text-amber-800">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </li>
                    @empty
                        <li class="px-6 py-12 text-center text-slate-400">No bookings yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
