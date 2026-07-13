<x-layouts.marketing title="Blog">

    <section class="mx-auto max-w-6xl px-6 py-16">
        <h1 class="text-center text-3xl font-bold text-slate-900 sm:text-4xl">Blog</h1>
        <p class="mx-auto mt-4 max-w-xl text-center text-slate-600">Guides for founders launching a business in Nigeria.</p>

        <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="block rounded-xl border border-slate-200 p-6 transition hover:border-brand-300">
                    <p class="text-xs font-medium uppercase tracking-wide text-brand-600">{{ $post->published_at->format('M j, Y') }}</p>
                    <h2 class="mt-2 text-lg font-semibold text-slate-900">{{ $post->title }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $post->excerpt }}</p>
                </a>
            @empty
                <p class="text-slate-500">No posts published yet.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    </section>

</x-layouts.marketing>
