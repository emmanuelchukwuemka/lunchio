<x-admin-layout>
    <x-slot name="header">Blog Posts Management</x-slot>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">All Blog Posts</h3>
            <a href="{{ route('admin.blog.create') }}" class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
                Create Post
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Author</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Published Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($posts as $post)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $post->title }}</td>
                        <td class="px-6 py-4">{{ $post->author->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4">
                            @if($post->published_at && $post->published_at <= now())
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-100 text-emerald-800">Published</span>
                            @else
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-slate-100 text-slate-800">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }}</td>
                        <td class="px-6 py-4 text-right flex justify-end gap-3">
                            <a href="{{ route('admin.blog.edit', $post) }}" class="text-brand-600 hover:text-brand-800 font-medium">Edit</a>
                            <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">No blog posts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>
