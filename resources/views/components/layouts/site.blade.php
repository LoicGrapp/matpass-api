@props([
    'title' => 'GymFlow — Le logiciel tout-en-un pour gérer votre salle de sport',
    'description' => 'GymFlow centralise vos membres, abonnements, plannings de cours et présences. La plateforme tout-en-un pour gérer votre salle de sport simplement.',
    'image' => null,
])

@php
    $ogImage = $image ?? asset('images/gym-hero.png');
@endphp

<!doctype html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="GymFlow">
    <meta property="og:locale" content="fr_BE">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Polices auto-hébergées (Anton, Geist, JetBrains Mono) via le plugin Vite --}}
    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? '' }}
</head>
<body class="min-h-screen bg-bg text-fg antialiased">
    <x-site-header />

    <main>
        {{ $slot }}
    </main>

    <x-site-footer />
</body>
</html>
