<x-layouts.marketing title="Contact">

    <section class="mx-auto max-w-5xl px-6 py-16">
        <h1 class="text-center text-3xl font-bold text-slate-900 sm:text-4xl">Get in touch</h1>
        <p class="mx-auto mt-4 max-w-xl text-center text-slate-600">
            Reach us however is easiest — we typically respond within one business day.
        </p>

        <div class="mt-12 grid gap-10 sm:grid-cols-2">
            <div class="space-y-6">
                <div class="rounded-xl border border-slate-200 p-5">
                    <h2 class="font-semibold text-slate-900">WhatsApp</h2>
                    @php $number = preg_replace('/\D/', '', config('services.whatsapp.number', '')); @endphp
                    @if ($number)
                        <a href="https://wa.me/{{ $number }}" target="_blank" rel="noopener" class="mt-1 block text-sm text-brand-700">
                            Chat with us instantly &rarr;
                        </a>
                    @endif
                </div>

                <div class="rounded-xl border border-slate-200 p-5">
                    <h2 class="font-semibold text-slate-900">Email</h2>
                    <a href="mailto:hello@launchio.com" class="mt-1 block text-sm text-brand-700">hello@launchio.com</a>
                </div>

                <div class="rounded-xl border border-slate-200 p-5">
                    <h2 class="font-semibold text-slate-900">Office</h2>
                    <p class="mt-1 text-sm text-slate-600">Address to be confirmed — Lagos, Nigeria.</p>
                </div>
            </div>

            <div>
                @if (session('status'))
                    <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700">Message</label>
                        <textarea name="message" id="message" rows="5" required
                            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                        Send message
                    </button>
                </form>
            </div>
        </div>
    </section>

</x-layouts.marketing>
