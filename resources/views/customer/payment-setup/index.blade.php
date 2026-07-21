<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('Payment Setup') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8 max-w-xl">
                <h3 class="font-semibold text-slate-900 mb-2">Not Connected Yet</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Launchio doesn't yet support connecting your own payment gateway (e.g. Paystack, Flutterwave) to accept payments from your own customers &mdash; that's a real integration your Launchio team needs to build first.
                    In the meantime, you can request payment setup as part of your package via <a href="{{ route('messages.index') }}" class="text-brand-600 hover:text-brand-800 font-medium">Messages</a>.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
