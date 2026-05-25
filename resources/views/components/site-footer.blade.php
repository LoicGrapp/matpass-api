@php
    $columns = [
        'Produit' => [
            ['Fonctionnalités', route('home') . '#fonctionnalites'],
            ['Tarifs', route('home') . '#tarifs'],
            ['Intégrations', '#'],
            ['Changelog', '#'],
        ],
        'Entreprise' => [
            ['À propos', '#'],
            ['Blog', route('blog.index')],
            ['Carrières', '#'],
            ['Contact', route('home') . '#contact'],
        ],
        'Légal' => [
            ['Mentions légales', '#'],
            ['CGU', '#'],
            ['Confidentialité', '#'],
            ['RGPD', '#'],
        ],
    ];

    $socials = [
        ['twitter', 'Twitter', 'M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z'],
        ['instagram', 'Instagram', 'M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z M17.5 6.5h.01'],
        ['linkedin', 'LinkedIn', 'M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z M2 9h4v12H2z M4 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z'],
        ['youtube', 'YouTube', 'M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z M9.75 15.02l5.75-3.27-5.75-3.27z'],
    ];
@endphp

<footer class="bg-bg-deep">
    <div class="mx-auto max-w-[1200px] px-6 py-12 lg:px-8">
        <div class="flex flex-col justify-between gap-12 md:flex-row">
            {{-- Bloc gauche : logo + description + réseaux --}}
            <div class="max-w-xs">
                <a href="{{ route('home') }}" class="font-display text-2xl tracking-wide">
                    <span class="text-fg">Gym</span><span class="text-primary">Flow</span>
                </a>
                <p class="mt-4 text-sm leading-relaxed text-muted">
                    La plateforme tout-en-un pour la gestion de votre salle de sport.
                </p>
                <div class="mt-4 flex gap-4">
                    @foreach ($socials as [$key, $label, $path])
                        <a href="#" aria-label="{{ $label }}" class="text-muted transition-colors hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="{{ $path }}" />
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Colonnes de liens --}}
            <div class="grid grid-cols-2 gap-10 sm:grid-cols-3 sm:gap-16">
                @foreach ($columns as $heading => $items)
                    <div>
                        <h3 class="text-sm font-semibold text-fg">{{ $heading }}</h3>
                        <ul class="mt-4 space-y-3">
                            @foreach ($items as [$label, $href])
                                <li>
                                    <a href="{{ $href }}" class="text-sm text-muted transition-colors hover:text-fg">{{ $label }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="my-12 h-px w-full bg-line"></div>

        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
            <p class="text-sm text-muted">© {{ date('Y') }} GymFlow. Tous droits réservés.</p>
            <p class="font-mono text-xs text-muted-soft">Conçu pour les salles de sport modernes</p>
        </div>
    </div>
</footer>
