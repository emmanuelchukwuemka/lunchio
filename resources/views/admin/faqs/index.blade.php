<x-admin-layout>
    <x-slot name="header">FAQs</x-slot>

    <div class="mb-10 flex flex-col xl:flex-row xl:items-end justify-between gap-6 border-b border-slate-200 pb-8">
        <div>
            <h2 class="text-xl font-medium text-slate-900">Frequently Asked Questions</h2>
            <p class="mt-2 text-sm text-slate-500">Manage the FAQs shown on the marketing site.</p>
        </div>

        <div class="bg-slate-50 p-4 rounded-md border border-slate-200 w-full xl:w-auto">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-3">Add New FAQ</h3>
            <form action="{{ route('admin.faqs.store') }}" method="POST" class="flex flex-col gap-3 xl:w-96">
                @csrf
                <input type="text" name="question" placeholder="Question" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                <textarea name="answer" placeholder="Answer" required rows="2" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500"></textarea>
                <div class="flex gap-3">
                    <input type="text" name="category" placeholder="Category" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500 flex-1">
                    <input type="number" name="sort_order" placeholder="Order" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500 w-24">
                </div>
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
                        <th class="px-6 py-4">Question</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Order</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($faqs as $faq)
                        <tr x-data="{ editing: false }">
                            <td class="px-6 py-4 font-medium text-slate-900 align-top">
                                <div x-show="!editing">{{ $faq->question }}</div>
                                <div x-show="!editing" class="text-xs text-slate-500 font-normal mt-1 max-w-md">{{ Str::limit($faq->answer, 120) }}</div>

                                <form x-show="editing" action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="flex flex-col gap-2 max-w-md">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="question" value="{{ $faq->question }}" required class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">
                                    <textarea name="answer" required rows="2" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500">{{ $faq->answer }}</textarea>
                                    <div class="flex gap-2">
                                        <input type="text" name="category" value="{{ $faq->category }}" placeholder="Category" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500 flex-1">
                                        <input type="number" name="sort_order" value="{{ $faq->sort_order }}" class="text-sm rounded-md border-slate-300 focus:border-brand-500 focus:ring-brand-500 w-20">
                                        <button type="submit" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-medium rounded-md hover:bg-slate-800 transition">Save</button>
                                    </div>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-slate-500 align-top">{{ $faq->category ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-500 align-top">{{ $faq->sort_order }}</td>
                            <td class="px-6 py-4 text-right align-top">
                                <div class="flex items-center gap-3 justify-end">
                                    <button type="button" @click="editing = !editing" class="text-brand-600 hover:text-brand-800 font-medium" x-text="editing ? 'Cancel' : 'Edit'"></button>
                                    <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Delete this FAQ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">No FAQs yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
