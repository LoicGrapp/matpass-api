@props(['post', 'compact' => false])

<a href="{{ route('blog.show', $post) }}"
   class="group flex flex-col overflow-hidden rounded border border-line bg-card transition-colors hover:border-muted-soft">
    <div class="aspect-[16/9] w-full overflow-hidden">
        <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}"
             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
             loading="lazy">
    </div>
    <div class="flex flex-1 flex-col gap-3 p-6">
        <span class="self-start rounded-full border border-primary px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-primary">
            {{ $post->category }}
        </span>
        <h3 class="font-display text-xl leading-tight text-fg transition-colors group-hover:text-primary">
            {{ $post->title }}
        </h3>
        @unless ($compact)
            <p class="text-sm leading-relaxed text-muted">{{ $post->excerpt }}</p>
        @endunless
        <div class="mt-auto flex items-center gap-2.5 pt-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-line text-[11px] font-semibold text-fg">
                {{ $post->author_initials }}
            </span>
            <span class="text-xs text-muted">{{ $post->author_name }} · {{ $post->published_date }}</span>
        </div>
    </div>
</a>
