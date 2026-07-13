<x-layouts.marketing :title="$post->title" :description="$post->excerpt">

    <article class="mx-auto max-w-3xl px-6 py-16">
        <p class="text-xs font-medium uppercase tracking-wide text-brand-600">{{ $post->published_at->format('M j, Y') }}</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900 sm:text-4xl">{{ $post->title }}</h1>

        <div class="prose prose-slate mt-8 max-w-none">
            {!! $post->body !!}
        </div>

        <div class="mt-12 border-t border-slate-100 pt-8">
            <a href="{{ route('blog.index') }}" class="text-sm font-semibold text-brand-700">&larr; Back to blog</a>
        </div>
    </article>

</x-layouts.marketing>
