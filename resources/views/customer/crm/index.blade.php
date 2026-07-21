<x-app-layout>
    <x-slot name="header">
        <h2 class="font-sora font-bold text-3xl text-slate-900 leading-tight tracking-tight">
            {{ __('CRM') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="{ showForm: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="flex items-center justify-between">
                <div class="flex gap-2">
                    <a href="{{ route('crm.index') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ !$status ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">All</a>
                    <a href="{{ route('crm.index', ['status' => 'lead']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $status === 'lead' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">Leads</a>
                    <a href="{{ route('crm.index', ['status' => 'customer']) }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $status === 'customer' ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">Customers</a>
                </div>
                <button type="button" @click="showForm = !showForm" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
                    Add Contact
                </button>
            </div>

            <div x-show="showForm" x-cloak class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6">
                <form action="{{ route('crm.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    @csrf
                    <input type="text" name="name" placeholder="Name" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    <input type="email" name="email" placeholder="Email" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    <input type="text" name="phone" placeholder="Phone (e.g. 2348012345678)" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    <select name="status" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                        <option value="lead">Lead</option>
                        <option value="customer">Customer</option>
                    </select>
                    <input type="text" name="source" placeholder="Source (e.g. Instagram)" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-md hover:bg-slate-800 transition lg:col-span-5 lg:w-40">Save Contact</button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Contact</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Source</th>
                                <th class="px-6 py-4">Last Contacted</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($contacts as $contact)
                                <tr x-data="{ following: false }">
                                    <td class="px-6 py-4 font-medium text-slate-900 align-top">{{ $contact->name }}</td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="flex flex-col gap-1">
                                            @if($contact->email)
                                                <a href="mailto:{{ $contact->email }}" class="text-brand-600 hover:text-brand-800 text-xs">{{ $contact->email }}</a>
                                            @endif
                                            @if($contact->phone)
                                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $contact->phone) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 text-xs">WhatsApp {{ $contact->phone }}</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $contact->status === 'customer' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ ucfirst($contact->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-top">{{ $contact->source ?? '—' }}</td>
                                    <td class="px-6 py-4 align-top text-slate-500">{{ $contact->last_contacted_at?->diffForHumans() ?? 'Never' }}</td>
                                    <td class="px-6 py-4 text-right align-top">
                                        <div class="flex items-center gap-3 justify-end">
                                            <button type="button" @click="following = !following" class="text-brand-600 hover:text-brand-800 font-medium" x-text="following ? 'Close' : 'Log Follow-up'"></button>
                                            <form action="{{ route('crm.destroy', $contact) }}" method="POST" onsubmit="return confirm('Remove this contact?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Remove</button>
                                            </form>
                                        </div>
                                        <div x-show="following" x-cloak class="mt-3 text-left">
                                            <form action="{{ route('crm.follow-ups.store', $contact) }}" method="POST" class="flex flex-col gap-2">
                                                @csrf
                                                <textarea name="note" rows="2" required placeholder="What happened?" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500"></textarea>
                                                <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-medium rounded-md hover:bg-slate-800 transition self-start">Save</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">No contacts yet. Add your first lead or customer above.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
