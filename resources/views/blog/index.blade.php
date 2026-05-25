<x-layouts.site
    title="Blog GymFlow — Conseils de gestion et de fitness pour votre salle de sport"
    description="Le journal GymFlow : conseils de gestion, tendances du fitness et retours d'expérience pour faire grandir votre salle de sport.">

    {{-- ============ EN-TÊTE BLOG ============ --}}
    <section class="bg-bg-deep">
        <div class="mx-auto flex max-w-[1200px] flex-col items-center px-6 py-20 text-center lg:px-8">
            <p class="eyebrow">Blog</p>
            <h1 class="mt-4 font-display text-4xl text-fg sm:text-5xl lg:text-[56px]">Le journal GymFlow</h1>
            <p class="mt-5 max-w-[640px] text-lg leading-relaxed text-muted-soft">
                Conseils de gestion, tendances du fitness et retours d'expérience pour faire grandir
                votre salle de sport.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('blog.index') }}"
                   @class([
                       'rounded-full px-5 py-2 text-sm transition-colors',
                       'bg-primary font-semibold text-primary-foreground' => ! $active,
                       'border border-line text-muted-soft hover:text-fg' => $active,
                   ])>Tous</a>
                @foreach ($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category]) }}"
                       @class([
                           'rounded-full px-5 py-2 text-sm transition-colors',
                           'bg-primary font-semibold text-primary-foreground' => $active === $category,
                           'border border-line text-muted-soft hover:text-fg' => $active !== $category,
                       ])>{{ $category }}</a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ CORPS BLOG ============ --}}
    <section class="bg-bg">
        <div class="mx-auto max-w-[1200px] px-6 py-16 lg:px-8">

            {{-- Article à la une --}}
            @if ($featured)
                <a href="{{ route('blog.show', $featured) }}"
                   class="group grid overflow-hidden rounded border border-line bg-card transition-colors hover:border-muted-soft lg:grid-cols-2">
                    <div class="aspect-[16/10] w-full overflow-hidden lg:aspect-auto">
                        <img src="{{ asset($featured->cover_image) }}" alt="{{ $featured->title }}"
                             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <div class="flex flex-col justify-center gap-5 p-8 lg:p-12">
                        <div class="flex items-center gap-3">
                            <span class="rounded-full bg-primary px-3.5 py-1.5 text-[11px] font-semibold uppercase tracking-wide text-primary-foreground">À la une</span>
                            <span class="text-[13px] text-muted">{{ $featured->category }}</span>
                        </div>
                        <h2 class="font-display text-3xl leading-tight text-fg lg:text-[34px]">{{ $featured->title }}</h2>
                        <p class="text-base leading-relaxed text-muted">{{ $featured->excerpt }}</p>
                        <div class="flex items-center gap-3 pt-2">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-[13px] font-semibold text-primary-foreground">{{ $featured->author_initials }}</span>
                            <div>
                                <div class="text-sm font-semibold text-fg">{{ $featured->author_name }}</div>
                                <div class="text-[13px] text-muted">{{ $featured->meta_line }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            @endif

            {{-- Grille d'articles --}}
            <div class="{{ $featured ? 'mt-14' : '' }} flex items-end justify-between">
                <h2 class="font-display text-2xl text-fg sm:text-3xl">
                    {{ $active ? 'Catégorie : '.$active : 'Articles récents' }}
                </h2>
                <span class="text-sm text-muted">{{ $posts->count() }} article{{ $posts->count() > 1 ? 's' : '' }}</span>
            </div>

            @if ($posts->isEmpty())
                <p class="mt-8 text-muted">Aucun article dans cette catégorie pour le moment.</p>
            @else
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <x-article-card :post="$post" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============ NEWSLETTER ============ --}}
    <section class="bg-bg-deep">
        <div class="mx-auto max-w-[1200px] px-6 py-20 lg:px-8">
            <div class="flex flex-col items-center gap-5 rounded-2xl border border-line bg-card px-6 py-14 text-center lg:px-16">
                <x-icon name="mail" class="h-9 w-9 text-primary" />
                <h2 class="font-display text-3xl text-fg sm:text-4xl">Recevez nos meilleurs conseils</h2>
                <p class="max-w-xl leading-relaxed text-muted">
                    Un email par mois, zéro spam. Les meilleures pratiques pour gérer et faire grandir
                    votre salle de sport, directement dans votre boîte.
                </p>
                <form class="mt-2 flex w-full max-w-md flex-col gap-3 sm:flex-row" onsubmit="return false">
                    <input type="email" required placeholder="Votre adresse email"
                           class="h-12 flex-1 rounded border border-line bg-ink px-4 text-sm text-fg placeholder:text-muted-soft focus:border-primary focus:outline-none">
                    <button type="submit"
                            class="h-12 rounded bg-primary px-6 text-sm font-semibold text-primary-foreground transition-opacity hover:opacity-90">
                        S'inscrire
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.site>
