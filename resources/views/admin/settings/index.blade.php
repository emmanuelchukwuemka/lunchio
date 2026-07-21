<x-admin-layout>
    <x-slot name="header">Settings</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
            <h3 class="font-semibold text-slate-900 mb-4">Your Account</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Name</dt>
                    <dd class="text-slate-900 font-medium">{{ auth()->user()->name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Email</dt>
                    <dd class="text-slate-900 font-medium">{{ auth()->user()->email }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Role</dt>
                    <dd class="text-slate-900 font-medium">{{ ucfirst(auth()->user()->roles->first()?->name ?? 'N/A') }}</dd>
                </div>
            </dl>
            <a href="{{ route('profile.edit') }}" class="inline-block mt-6 text-sm font-medium text-brand-600 hover:text-brand-800">Edit Profile &rarr;</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8">
            <h3 class="font-semibold text-slate-900 mb-4">Platform</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Application</dt>
                    <dd class="text-slate-900 font-medium">{{ config('app.name') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Environment</dt>
                    <dd class="text-slate-900 font-medium">{{ config('app.env') }}</dd>
                </div>
            </dl>
            <p class="text-xs text-slate-400 mt-6 leading-relaxed">
                Broader platform configuration (payment gateway keys, email templates, notification preferences) isn't wired up to this page yet &mdash; those still live in the <code class="bg-slate-100 px-1 rounded">.env</code> file.
            </p>
        </div>
    </div>
</x-admin-layout>
