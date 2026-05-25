<x-layouts.site
    :title="$post->title.' — Blog GymFlow'"
    :description="$post->excerpt"
    :image="asset($post->cover_image)">

    {{-- Données structurées Article (SEO) --}}
    @php
        $jsonLd = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->excerpt,
            'image' => asset($post->cover_image),
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'author' => ['@type' => 'Person', 'name' => $post->author_name],
            'publisher' => ['@type' => 'Organization', 'name' => 'GymFlow'],
            'articleSection' => $post->category,
            'mainEntityOfPage' => route('blog.show', $post),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    @endphp
    <x-slot:head>
        <script type="application/ld+json">{!! $jsonLd !!}</script>
    </x-slot:head>

    {{-- ============ HERO ARTICLE ============ --}}
    <section class="bg-bg-deep">
        <div class="mx-auto flex max-w-[780px] flex-col items-center px-6 py-16 text-center">
            <a href="{{ route('blog.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition-opacity hover:opacity-80">
                <x-icon name="arrow-left" class="h-4 w-4" /> Retour au blog
            </a>

            <span class="mt-6 rounded-full bg-primary px-3.5 py-1.5 text-[11px] font-semibold uppercase tracking-wide text-primary-foreground">
                {{ $post->category }}
            </span>

            <h1 class="mt-6 font-display text-4xl leading-[1.1] text-fg sm:text-5xl lg:text-[52px]">
                {{ $post->title }}
            </h1>

            <p class="mt-6 max-w-[640px] text-lg leading-relaxed text-muted-soft">{{ $post->excerpt }}</p>

            <div class="mt-8 flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-primary text-[15px] font-semibold text-primary-foreground">{{ $post->author_initials }}</span>
                <div class="text-left">
                    <div class="text-[15px] font-semibold text-fg">{{ $post->author_name }}</div>
                    <div class="text-[13px] text-muted-soft">Publié le {{ $post->meta_line }}</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ CORPS ARTICLE ============ --}}
    <section class="bg-bg">
        <div class="mx-auto max-w-[1000px] px-6 pt-12 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-line">
                <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}"
                     class="aspect-[1000/460] w-full object-cover">
            </div>
        </div>

        <div class="mx-auto max-w-[760px] px-6 py-14">
            {{-- Corps de l'article (HTML sémantique stocké en base) --}}
            <div class="article-prose">
                {!! $post->body !!}
            </div>

            {{-- Tags --}}
            @if ($post->tags)
                <div class="mt-10 flex flex-wrap gap-2.5">
                    @foreach ($post->tags as $tag)
                        <span class="rounded-full bg-line px-3.5 py-1.5 text-[13px] text-fg">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            <div class="my-10 h-px w-full bg-line"></div>

            {{-- Bio auteur --}}
            <div class="flex flex-col gap-5 rounded-2xl border border-line bg-card p-7 sm:flex-row">
                <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-primary font-display text-2xl text-primary-foreground">{{ $post->author_initials }}</span>
                <div>
                    <p class="eyebrow text-xs">Écrit par</p>
                    <p class="mt-1 font-display text-xl text-fg">{{ $post->author_name }}</p>
                    <p class="mt-2 text-[15px] leading-relaxed text-muted">{{ $post->author_bio }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ À LIRE ENSUITE ============ --}}
    @if ($related->isNotEmpty())
        <section class="bg-bg-deep">
            <div class="mx-auto max-w-[1200px] px-6 py-16 lg:px-8">
                <h2 class="font-display text-2xl text-fg sm:text-3xl">À lire ensuite</h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $post)
                        <x-article-card :post="$post" compact />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.site>
