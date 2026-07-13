<x-layouts.marketing title="Get Started">

    <section class="mx-auto max-w-lg px-6 py-20">
        <h1 class="text-center text-3xl font-bold text-slate-900">Let's start your launch</h1>
        <p class="mt-3 text-center text-slate-600">Tell us a little about you — it only takes a minute.</p>

        @if (session('status'))
            <div class="mt-6 rounded-lg bg-green-50 p-4 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('get-started.store') }}" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Full name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700">Phone number <span class="text-slate-400">(optional)</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                    class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="package_interest_id" class="block text-sm font-medium text-slate-700">Package interested in <span class="text-slate-400">(optional)</span></label>
                <select name="package_interest_id" id="package_interest_id"
                    class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                    <option value="">Not sure yet</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}" @selected(old('package_interest_id', request('package')) == $package->id)>{{ $package->name }}</option>
                    @endforeach
                </select>
                @error('package_interest_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                Continue
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500">
            Already have an account? <a href="{{ route('login') }}" class="font-semibold text-brand-700">Log in</a>
        </p>
    </section>

</x-layouts.marketing>
