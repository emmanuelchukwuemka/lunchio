<x-admin-layout>
    <x-slot name="header">Testimonials</x-slot>

    <div class="mb-10 flex flex-col xl:flex-row xl:items-end justify-between gap-6 border-b border-slate-200 pb-8">
        <div>
            <h2 class="text-xl font-medium text-slate-900">Customer Testimonials</h2>
            <p class="mt-2 text-sm text-slate-500">Manage the testimonials shown on the marketing site.</p>
        </div>

        <div class="bg-slate-50 p-4 rounded-md border border-slate-200 w-full xl:w-auto">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Add New Testimonial</h3>
            <form action="{{ route('admin.testimonials.store') }}" method="POST" class="flex flex-col gap-3 xl:w-96">
                @csrf
                <input type="text" name="name" placeholder="Customer Name" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                <input type="text" name="role_company" placeholder="Role / Company" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                <textarea name="quote" placeholder="Quote" required rows="2" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500"></textarea>
                <input type="number" name="sort_order" placeholder="Order" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500 w-24">
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-md hover:bg-slate-800 transition">Create</button>
            </form>
            @if($errors->any())
                <div class="mt-2 text-xs text-red-600 font-medium">{{ $errors->first() }}</div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Testimonial</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($testimonials as $testimonial)
                        <tr x-data="{ editing: false }">
                            <td class="px-6 py-4 align-top">
                                <div x-show="!editing">
                                    <p class="font-medium text-slate-900">{{ $testimonial->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $testimonial->role_company }}</p>
                                    <p class="text-sm text-slate-600 mt-1 max-w-lg">"{{ Str::limit($testimonial->quote, 140) }}"</p>
                                </div>

                                <form x-show="editing" action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" class="flex flex-col gap-2 max-w-lg">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $testimonial->name }}" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                    <input type="text" name="role_company" value="{{ $testimonial->role_company }}" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                    <textarea name="quote" required rows="2" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">{{ $testimonial->quote }}</textarea>
                                    <div class="flex gap-2">
                                        <input type="number" name="sort_order" value="{{ $testimonial->sort_order }}" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500 w-20">
                                        <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-medium rounded-md hover:bg-slate-800 transition">Save</button>
                                    </div>
                                </form>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $testimonial->active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $testimonial->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right align-top">
                                <div class="flex items-center gap-3 justify-end">
                                    <button type="button" @click="editing = !editing" class="text-brand-600 hover:text-brand-800 font-medium" x-text="editing ? 'Cancel' : 'Edit'"></button>
                                    <form action="{{ route('admin.testimonials.toggle', $testimonial) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-slate-600 hover:text-slate-800 font-medium">
                                            {{ $testimonial->active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Delete this testimonial?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-400">No testimonials yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
