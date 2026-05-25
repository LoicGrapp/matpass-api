@php
    $features = [
        ['icon' => 'users', 'title' => 'Gestion des Membres', 'desc' => "Inscriptions, abonnements, profils et historique de chaque membre en un coup d'œil."],
        ['icon' => 'calendar', 'title' => 'Planning des Cours', 'desc' => 'Créez et gérez vos cours, assignez des coachs et permettez les réservations en ligne.'],
        ['icon' => 'clipboard-check', 'title' => 'Suivi des Présences', 'desc' => 'Check-in automatique, statistiques de fréquentation et rapports détaillés.'],
    ];

    $stats = [
        ['value' => '+500', 'label' => 'Salles'],
        ['value' => '+50 000', 'label' => 'Membres gérés'],
        ['value' => '99.9%', 'label' => 'Uptime'],
        ['value' => '4.9/5', 'label' => 'Satisfaction'],
    ];

    $testimonials = [
        ['quote' => "GymFlow a transformé la gestion de notre salle. Nous avons gagné 10h par semaine sur l'administratif.", 'name' => 'Sophie Martin', 'org' => 'FitClub Paris'],
        ['quote' => 'Le planning en ligne et les réservations ont doublé notre taux de remplissage des cours.', 'name' => 'Marc Dupont', 'org' => 'Iron Gym Lyon'],
        ['quote' => "Le suivi des présences nous a permis d'optimiser nos horaires et d'améliorer l'expérience membre.", 'name' => 'Julie Lefèvre', 'org' => 'CrossFit Bordeaux'],
    ];

    $plans = [
        [
            'name' => 'Starter', 'price' => '29€', 'period' => '/mois',
            'desc' => "Idéal pour les petites salles jusqu'à 100 membres",
            'features' => ['Jusqu\'à 100 membres', 'Gestion des cours', 'Suivi des présences', 'Support email'],
            'cta' => 'Commencer', 'cta_style' => 'gray', 'popular' => false,
        ],
        [
            'name' => 'Pro', 'price' => '59€', 'period' => '/mois',
            'desc' => 'Pour les salles en croissance jusqu\'à 500 membres',
            'features' => ['Jusqu\'à 500 membres', 'Gestion avancée des cours', 'Suivi des présences + analytics', 'Paiements en ligne', 'Support prioritaire', 'App mobile membres'],
            'cta' => "Commencer l'essai gratuit", 'cta_style' => 'primary', 'popular' => true,
        ],
        [
            'name' => 'Enterprise', 'price' => 'Sur mesure', 'period' => '',
            'desc' => 'Pour les réseaux de salles et franchises sans limite',
            'features' => ['Membres illimités', 'Multi-salles & franchises', 'API & intégrations custom', 'Account manager dédié', 'SLA garanti 99.99%', 'Formation & onboarding'],
            'cta' => "Contacter l'équipe", 'cta_style' => 'outline', 'popular' => false,
        ],
    ];
@endphp

<x-layouts.site>
    {{-- ============ HERO ============ --}}
    <section class="bg-bg-deep">
        <div class="mx-auto flex max-w-[1200px] flex-col items-center px-6 py-20 text-center lg:px-8 lg:py-28">
            <h1 class="max-w-3xl font-display text-4xl leading-[1.1] text-fg sm:text-5xl lg:text-6xl">
                Gérez votre salle de sport.<br>Simplement.
            </h1>
            <p class="mt-6 max-w-[680px] text-lg leading-relaxed text-muted-soft">
                GymFlow est la plateforme tout-en-un pour gérer vos membres, planifier vos cours et suivre
                les présences. Concentrez-vous sur vos athlètes, on s'occupe du reste.
            </p>
            <div class="mt-10 flex flex-col items-center gap-4 sm:flex-row">
                <a href="#tarifs"
                   class="rounded bg-primary px-8 py-4 text-base font-semibold text-primary-foreground transition-opacity hover:opacity-90">
                    Commencer gratuitement
                </a>
                <a href="#fonctionnalites"
                   class="inline-flex items-center gap-2 rounded border border-line bg-card px-8 py-4 text-base font-semibold text-fg transition-colors hover:border-muted-soft">
                    <x-icon name="play" class="h-[18px] w-[18px]" /> Voir la démo
                </a>
            </div>
            <div class="mt-16 w-full max-w-[1000px] overflow-hidden rounded-2xl border border-line">
                <img src="{{ asset('images/gym-hero.png') }}"
                     alt="Tableau de bord GymFlow utilisé dans une salle de sport"
                     class="aspect-[2/1] w-full object-cover">
            </div>
        </div>
    </section>

    {{-- ============ FONCTIONNALITÉS ============ --}}
    <section id="fonctionnalites" class="scroll-mt-20 bg-bg">
        <div class="mx-auto max-w-[1200px] px-6 py-20 lg:px-8 lg:py-28">
            <div class="flex flex-col items-center text-center">
                <p class="eyebrow">Fonctionnalités</p>
                <h2 class="mt-3 font-display text-3xl text-fg sm:text-4xl">Tout ce dont vous avez besoin</h2>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach ($features as $f)
                    <div class="rounded border border-line bg-card p-8">
                        <x-icon :name="$f['icon']" class="h-8 w-8 text-primary" />
                        <h3 class="mt-4 font-display text-xl text-fg">{{ $f['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-muted">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ RÉASSURANCE ============ --}}
    <section id="temoignages" class="scroll-mt-20 bg-bg-deep">
        <div class="mx-auto max-w-[1200px] px-6 py-20 lg:px-8 lg:py-28">
            <div class="text-center">
                <p class="eyebrow">Ils nous font confiance</p>
            </div>

            <div class="mt-12 grid grid-cols-2 gap-8 md:grid-cols-4">
                @foreach ($stats as $stat)
                    <div class="flex flex-col items-center">
                        <span class="font-display text-4xl text-fg">{{ $stat['value'] }}</span>
                        <span class="mt-1 text-sm text-muted">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 grid gap-6 md:grid-cols-3">
                @foreach ($testimonials as $t)
                    <figure class="flex flex-col gap-4 rounded border border-line bg-card p-6">
                        <blockquote class="text-sm italic leading-relaxed text-fg">« {{ $t['quote'] }} »</blockquote>
                        <figcaption>
                            <div class="text-sm font-semibold text-fg">{{ $t['name'] }}</div>
                            <div class="text-[13px] text-muted">{{ $t['org'] }}</div>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ TARIFS ============ --}}
    <section id="tarifs" class="scroll-mt-20 bg-bg">
        <div class="mx-auto max-w-[1200px] px-6 py-20 lg:px-8 lg:py-28">
            <div class="flex flex-col items-center text-center">
                <p class="eyebrow">Tarifs</p>
                <h2 class="mt-3 font-display text-3xl text-fg sm:text-4xl lg:text-[42px]">Des prix simples et transparents</h2>
                <p class="mt-4 max-w-[600px] text-base leading-relaxed text-muted">
                    Choisissez le plan adapté à la taille de votre salle. Sans engagement, sans surprise.
                </p>
            </div>

            <div class="mt-12 grid items-start gap-6 lg:grid-cols-3">
                @foreach ($plans as $plan)
                    <div @class([
                        'flex flex-col gap-6 rounded-lg bg-card p-8',
                        'border-2 border-primary shadow-[0_8px_40px_-8px_rgba(255,132,0,0.35)]' => $plan['popular'],
                        'border border-line' => ! $plan['popular'],
                    ])>
                        <div class="flex items-center justify-between">
                            <span @class([
                                'text-xs font-semibold tracking-widest',
                                'text-primary' => $plan['popular'],
                                'text-muted' => ! $plan['popular'],
                            ])>{{ strtoupper($plan['name']) }}</span>
                            @if ($plan['popular'])
                                <span class="rounded-full bg-primary px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-primary-foreground">Populaire</span>
                            @endif
                        </div>

                        <div class="flex items-end gap-1">
                            <span @class(['font-display text-fg', 'text-5xl' => $plan['price'] !== 'Sur mesure', 'text-4xl' => $plan['price'] === 'Sur mesure'])>{{ $plan['price'] }}</span>
                            @if ($plan['period'])
                                <span class="pb-1 text-base text-muted">{{ $plan['period'] }}</span>
                            @endif
                        </div>

                        <p class="text-sm leading-relaxed text-muted">{{ $plan['desc'] }}</p>

                        <div class="h-px w-full bg-line"></div>

                        <ul class="flex flex-col gap-3">
                            @foreach ($plan['features'] as $feature)
                                <li class="flex items-center gap-2.5">
                                    <x-icon name="check" class="h-[18px] w-[18px] shrink-0 text-primary" />
                                    <span class="text-sm text-fg">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ $plan['cta_style'] === 'outline' ? route('home') . '#contact' : '#' }}"
                           @class([
                               'mt-auto flex h-12 items-center justify-center rounded-full text-sm font-semibold transition-opacity',
                               'bg-primary text-primary-foreground hover:opacity-90' => $plan['cta_style'] === 'primary',
                               'bg-line text-fg hover:opacity-90' => $plan['cta_style'] === 'gray',
                               'border border-line bg-ink text-fg hover:border-muted-soft' => $plan['cta_style'] === 'outline',
                           ])>
                            {{ $plan['cta'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ CTA / CONTACT ============ --}}
    <section id="contact" class="scroll-mt-20 bg-bg-deep">
        <div class="mx-auto max-w-[1200px] px-6 py-20 lg:px-8">
            <div class="rounded-2xl border border-line bg-card p-10 text-center lg:p-16">
                <h2 class="font-display text-3xl text-fg sm:text-4xl">Prêt à transformer votre salle ?</h2>
                <p class="mx-auto mt-4 max-w-xl leading-relaxed text-muted">
                    Rejoignez les centaines de salles qui pilotent leur activité avec GymFlow.
                    Essai gratuit, sans carte bancaire.
                </p>
                <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <a href="#tarifs"
                       class="rounded bg-primary px-8 py-4 font-semibold text-primary-foreground transition-opacity hover:opacity-90">
                        Commencer gratuitement
                    </a>
                    <a href="mailto:contact@gymflow.be" class="font-mono text-sm text-muted transition-colors hover:text-fg">
                        contact@gymflow.be
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.site>
