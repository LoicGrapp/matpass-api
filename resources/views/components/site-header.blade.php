@php
    $links = [
        ['label' => 'Fonctionnalités', 'href' => route('home') . '#fonctionnalites'],
        ['label' => 'Tarifs', 'href' => route('home') . '#tarifs'],
        ['label' => 'Témoignages', 'href' => route('home') . '#temoignages'],
        ['label' => 'Blog', 'href' => route('blog.index')],
        ['label' => 'Contact', 'href' => route('home') . '#contact'],
    ];
@endphp

<header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-line bg-bg-deep/90 backdrop-blur-sm">
    <div class="mx-auto flex h-18 max-w-[1200px] items-center px-6 lg:px-8">
        <a href="{{ route('home') }}" class="font-display text-2xl tracking-wide" aria-label="Accueil GymFlow">
            <span class="text-fg">Gym</span><span class="text-primary">Flow</span>
        </a>

        <div class="flex-1"></div>

        <nav class="hidden items-center gap-8 md:flex" aria-label="Navigation principale">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}"
                   class="text-sm text-muted-soft transition-colors hover:text-fg">{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="flex-1"></div>

        <a href="{{ route('home') }}#tarifs"
           class="hidden rounded bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground transition-opacity hover:opacity-90 md:inline-block">
            Commencer
        </a>

        {{-- Bouton menu mobile --}}
        <button type="button" x-on:click="open = !open"
                class="inline-flex items-center justify-center rounded p-2 text-fg md:hidden"
                aria-label="Ouvrir le menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6" /><line x1="3" y1="12" x2="21" y2="12" /><line x1="3" y1="18" x2="21" y2="18" />
            </svg>
        </button>
    </div>

    {{-- Menu mobile déroulant --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="border-t border-line bg-bg-deep md:hidden">
        <nav class="mx-auto flex max-w-[1200px] flex-col gap-1 px-6 py-4">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" x-on:click="open = false"
                   class="rounded px-2 py-2 text-sm text-muted-soft transition-colors hover:bg-card hover:text-fg">{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ route('home') }}#tarifs" x-on:click="open = false"
               class="mt-2 rounded bg-primary px-4 py-3 text-center text-sm font-semibold text-primary-foreground">
                Commencer
            </a>
        </nav>
    </div>
</header>
