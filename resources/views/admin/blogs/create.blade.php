<x-admin-layout>
    <x-slot name="header">Create Blog Post</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.blog.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Posts
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-semibold text-slate-900">New Blog Post</h3>
        </div>
        
        <form action="{{ route('admin.blog.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Main Content Column -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                        @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                        <input type="text" name="slug" id="slug" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 @error('slug') border-red-500 @enderror" value="{{ old('slug') }}" required>
                        <p class="mt-1 text-xs text-slate-500">The URL-friendly version of the title. (e.g. my-first-post)</p>
                        @error('slug') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-slate-700 mb-1">Excerpt</label>
                        <textarea name="excerpt" id="excerpt" rows="3" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">A short summary displayed on the blog index page.</p>
                        @error('excerpt') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-medium text-slate-700 mb-1">Content (HTML or Markdown)</label>
                        <textarea name="body" id="body" rows="12" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 font-mono text-sm @error('body') border-red-500 @enderror" required>{{ old('body') }}</textarea>
                        @error('body') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="space-y-6">
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 space-y-4">
                        <h4 class="font-semibold text-slate-900 mb-4">Publishing Options</h4>
                        
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-slate-700 mb-1">Publish Date</label>
                            <input type="datetime-local" name="published_at" id="published_at" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm @error('published_at') border-red-500 @enderror" value="{{ old('published_at') }}">
                            <p class="mt-1 text-xs text-slate-500">Leave blank for Draft status.</p>
                            @error('published_at') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 space-y-4">
                        <h4 class="font-semibold text-slate-900 mb-4">Media & SEO</h4>

                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-slate-700 mb-1">Cover Image URL</label>
                            <input type="url" name="cover_image" id="cover_image" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm @error('cover_image') border-red-500 @enderror" value="{{ old('cover_image') }}">
                            @error('cover_image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="seo_keywords" class="block text-sm font-medium text-slate-700 mb-1">SEO Keywords</label>
                            <input type="text" name="seo_keywords" id="seo_keywords" class="w-full rounded-lg border-slate-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm @error('seo_keywords') border-red-500 @enderror" value="{{ old('seo_keywords') }}" placeholder="saas, startup, launch">
                            @error('seo_keywords') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.blog.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors shadow-sm">
                    Save Post
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('title').addEventListener('input', function() {
            let title = this.value;
            let slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/[\s-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slug;
        });
    </script>
</x-admin-layout>
