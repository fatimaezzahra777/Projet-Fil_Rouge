<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Second Chance - Plateforme de Soutien contre l'Addiction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden bg-[#F7F5F0] font-['DM_Sans'] text-[#0D1F1E]">
    @php
        $features = [
            ['label' => 'Suivi personnalise', 'icon' => 'user'],
            ['label' => '100% Confidentiel', 'icon' => 'check'],
            ['label' => 'Messagerie securisee', 'icon' => 'mail'],
            ['label' => 'Rendez-vous en ligne', 'icon' => 'calendar'],
        ];

        $services = [
            [
                'title' => 'Therapie individuelle',
                'desc' => 'Un suivi personnalise avec un professionnel de sante adapte a votre situation.',
                'image' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=400&q=80',
                'tags' => [
                    ['label' => '18-60 ans', 'class' => 'bg-[#8EB69B]/15 text-[#8EB69B]'],
                    ['label' => 'Individuel', 'class' => 'bg-[#235347]/40 text-[#7ECEC4]'],
                ],
            ],
            [
                'title' => 'Therapie de groupe',
                'desc' => 'Partagez et apprenez avec d autres personnes sur un chemin similaire au votre.',
                'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400&q=80',
                'tags' => [
                    ['label' => 'Groupe', 'class' => 'bg-[#8EB69B]/15 text-[#8EB69B]'],
                    ['label' => 'Solidaire', 'class' => 'bg-[#235347]/40 text-[#7ECEC4]'],
                ],
            ],
            [
                'title' => 'Accompagnement Jeunes',
                'desc' => 'Un espace dedie aux adolescents et jeunes adultes pour les guider vers un avenir meilleur.',
                'image' => 'https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=400&q=80',
                'tags' => [
                    ['label' => '15-25 ans', 'class' => 'bg-[#8EB69B]/15 text-[#8EB69B]'],
                    ['label' => 'Jeunes', 'class' => 'bg-[#163832]/60 text-[#8EB69B]'],
                ],
            ],
            [
                'title' => 'Suivi Medical',
                'desc' => 'Un espace confidentiel pour votre guerison et votre developpement personnel.',
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=400&q=80',
                'tags' => [
                    ['label' => '18-80 ans', 'class' => 'bg-[#8EB69B]/15 text-[#8EB69B]'],
                    ['label' => 'Prive', 'class' => 'bg-[#235347]/40 text-[#7ECEC4]'],
                ],
            ],
        ];

        $actors = [
            [
                'title' => 'Patient',
                'desc' => 'S inscrit, consulte des medecins, participe a des activites, gagne et depense des points, suit son parcours de guerison.',
                'card' => 'bg-[#DAF1DE] border-[#8EB69B]/30 text-[#0D1F1E]',
                'icon' => 'bg-[#235347]',
                'svg' => 'patient',
            ],
            [
                'title' => 'Medecin',
                'desc' => 'Gere ses disponibilites, confirme les rendez-vous et assure un suivi medical et psychologique de ses patients.',
                'card' => 'bg-[#EAF4F1] border-[#235347]/20 text-[#0D1F1E]',
                'icon' => 'bg-[#2D7A65]',
                'svg' => 'medecin',
            ],
            [
                'title' => 'Association',
                'desc' => 'Publie des activites sociales, des ateliers et des campagnes de sensibilisation pour aider la communaute.',
                'card' => 'bg-[#F0F7F2] border-[#163832]/15 text-[#0D1F1E]',
                'icon' => 'bg-[#1E5C4A]',
                'svg' => 'association',
            ],
            [
                'title' => 'Administrateur',
                'desc' => 'Gere les utilisateurs, valide les comptes professionnels, modere le contenu et consulte les statistiques.',
                'card' => 'bg-[#051F20] border-[#051F20] text-white',
                'icon' => 'bg-[#235347]',
                'svg' => 'admin',
            ],
        ];
    @endphp

    <nav class="fixed inset-x-0 top-0 z-50 border-b border-[#8EB69B]/15 bg-[#051F20]/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-6 py-4 lg:px-10">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="font-['Playfair_Display'] text-[1.3rem] font-bold tracking-[0.02em] text-white">
                    Second<span class="text-[#8EB69B]">Chance</span>
                </span>
            </a>

            <ul class="hidden items-center gap-9 text-sm font-medium tracking-[0.04em] text-white/70 lg:flex">
                <li><a href="#about" class="transition hover:text-[#8EB69B]">A propos</a></li>
                <li><a href="#services" class="transition hover:text-[#8EB69B]">Services</a></li>
                <li><a href="#points" class="transition hover:text-[#8EB69B]">Systeme de Points</a></li>
                <li><a href="#actors" class="transition hover:text-[#8EB69B]">Acteurs</a></li>
                <li><a href="#contact" class="transition hover:text-[#8EB69B]">Contact</a></li>
            </ul>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="rounded-full border border-[#8EB69B]/45 px-5 py-2 text-sm font-medium text-[#8EB69B] transition hover:border-[#8EB69B] hover:bg-[#8EB69B]/10">
                    Se connecter
                </a>
                <a href="{{ route('register') }}" class="rounded-full bg-[#235347] px-6 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-[#8EB69B] hover:text-[#051F20]">
                    S'inscrire
                </a>
            </div>
        </div>
    </nav>

    <section id="home" class="relative flex min-h-screen items-center overflow-hidden bg-[#051F20] px-6 pb-20 pt-32 lg:px-10">
        <div class="pointer-events-none absolute -right-40 -top-40 h-[44rem] w-[44rem] rounded-full bg-[radial-gradient(circle,_rgba(35,83,71,0.45)_0%,_transparent_70%)]"></div>
        <div class="pointer-events-none absolute bottom-[-7rem] left-[30%] h-[25rem] w-[25rem] rounded-full bg-[radial-gradient(circle,_rgba(11,43,38,0.6)_0%,_transparent_70%)]"></div>

        <div class="relative z-10 mx-auto grid w-full max-w-7xl items-center gap-14 lg:grid-cols-[minmax(0,600px)_minmax(0,1fr)]">
            <div class="reveal">
                <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-[#8EB69B]/30 bg-[#8EB69B]/15 px-4 py-1.5 text-xs font-medium uppercase tracking-[0.06em] text-[#8EB69B]">
                    <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-[#8EB69B]"></span>
                    Plateforme solidaire & securisee
                </div>

                <h1 class="mb-6 max-w-[11ch] font-['Playfair_Display'] text-5xl font-black leading-[1.05] text-white sm:text-6xl lg:text-[4.2rem]">
                    Votre <span class="text-[#8EB69B]">Second Chance</span> commence ici
                </h1>

                <p class="mb-10 max-w-xl text-[1.05rem] leading-8 text-white/60">
                    Un espace numerique bienveillant pour vous accompagner dans votre parcours de guerison, mettant en relation patients, medecins et associations grace a un systeme solidaire de points.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ auth()->check() ? route('rendezvous.index') : route('login') }}" class="inline-flex items-center gap-2 rounded-full bg-[#8EB69B] px-8 py-3.5 text-[0.95rem] font-bold text-[#051F20] transition hover:-translate-y-0.5 hover:bg-white hover:shadow-[0_12px_32px_rgba(142,182,155,0.3)]">
                        Prendre un rendez-vous
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="#about" class="rounded-full border border-white/30 px-8 py-3.5 text-[0.95rem] font-medium text-white transition hover:border-[#8EB69B] hover:text-[#8EB69B]">
                        En savoir plus
                    </a>
                </div>

                <div class="mt-14 flex flex-wrap gap-8 border-t border-white/10 pt-10">
                    <div>
                        <div class="mb-1 font-['Playfair_Display'] text-[2rem] font-bold leading-none text-[#8EB69B]">500+</div>
                        <div class="text-xs uppercase tracking-[0.05em] text-white/45">Patients accompagnes</div>
                    </div>
                    <div>
                        <div class="mb-1 font-['Playfair_Display'] text-[2rem] font-bold leading-none text-[#8EB69B]">80+</div>
                        <div class="text-xs uppercase tracking-[0.05em] text-white/45">Medecins partenaires</div>
                    </div>
                    <div>
                        <div class="mb-1 font-['Playfair_Display'] text-[2rem] font-bold leading-none text-[#8EB69B]">30+</div>
                        <div class="text-xs uppercase tracking-[0.05em] text-white/45">Associations actives</div>
                    </div>
                </div>
            </div>

            <div class="relative hidden h-[70vh] min-h-[32rem] overflow-hidden lg:block">
                <div class="absolute inset-0 z-10 bg-gradient-to-r from-[#051F20] via-[#051F20]/40 to-transparent"></div>
                <img
                    src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=900&q=80"
                    alt="Therapie et soutien"
                    class="h-full w-full object-cover object-top saturate-75 brightness-75"
                >
            </div>
        </div>
    </section>

    <section id="about" class="bg-white px-6 py-24 lg:px-10">
        <div class="mx-auto grid max-w-7xl items-center gap-16 lg:grid-cols-2 lg:gap-20">
            <div class="relative hidden lg:block reveal">
                <img
                    src="https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=700&q=80"
                    alt="Accompagnement"
                    class="block h-[30rem] w-full rounded-[20px] object-cover"
                >
                <div class="absolute -left-5 -top-5 rounded-2xl bg-[#235347] px-6 py-5 text-center text-white shadow-[0_10px_30px_rgba(35,83,71,0.4)]">
                    <div class="font-['Playfair_Display'] text-[2.2rem] font-bold leading-none">98%</div>
                    <div class="mt-1 text-[0.72rem] tracking-[0.04em] text-white/80">Taux de satisfaction</div>
                </div>
                <div class="absolute -bottom-7 -right-7 h-[12.5rem] w-[12.5rem] overflow-hidden rounded-2xl border-[6px] border-white shadow-[0_20px_50px_rgba(5,31,32,0.15)]">
                    <img
                        src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=300&q=80"
                        alt="Medecin"
                        class="h-full w-full object-cover"
                    >
                </div>
            </div>

            <div class="reveal">
                <span class="mb-3 inline-block text-xs font-semibold uppercase tracking-[0.12em] text-[#235347]">Notre mission</span>
                <h2 class="mb-5 font-['Playfair_Display'] text-4xl font-bold leading-[1.15] text-[#0D1F1E] sm:text-5xl">
                    Un parcours vers la <span class="text-[#235347]">guerison</span> accessible a tous
                </h2>
                <p class="max-w-xl text-base leading-8 text-[#3A5A52]">
                    L'addiction est un probleme de sante publique. Beaucoup de patients n'ont pas acces aux soins pour des raisons financieres ou sociales. Second Chance brise ces barrieres grace a la solidarite.
                </p>

                <div class="mt-9 grid gap-4 sm:grid-cols-2">
                    @foreach ($features as $feature)
                        <div class="flex items-center gap-3 rounded-xl bg-[#DAF1DE] px-4 py-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#235347]">
                                @if ($feature['icon'] === 'user')
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-white" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2a5 5 0 1 0 0 10A5 5 0 0 0 12 2zm0 12c-5.33 0-8 2.67-8 4v2h16v-2c0-1.33-2.67-4-8-4z"/>
                                    </svg>
                                @elseif ($feature['icon'] === 'check')
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-white" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/>
                                    </svg>
                                @elseif ($feature['icon'] === 'mail')
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-white" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>
                                    </svg>
                                @else
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-white" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm font-semibold text-[#163832]">{{ $feature['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="bg-[#051F20] px-6 py-24 text-white lg:px-10">
        <div class="mx-auto max-w-7xl">
            <div class="mb-14 flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="reveal">
                    <span class="mb-3 inline-block text-xs font-semibold uppercase tracking-[0.12em] text-[#8EB69B]">Nos services</span>
                    <h2 class="mb-5 font-['Playfair_Display'] text-4xl font-bold leading-[1.15] sm:text-5xl">
                        Votre chemin vers le <span class="text-[#8EB69B]">bien-etre</span>
                    </h2>
                    <p class="max-w-xl text-base leading-8 text-white/55">
                        Explorez nos programmes concus pour chaque type d'addiction et chaque besoin.
                    </p>
                </div>
               
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($services as $service)
                    <article class="reveal group relative overflow-hidden rounded-[20px] border border-[#8EB69B]/10 bg-[#0B2B26] p-7 transition duration-300 hover:-translate-y-1.5 hover:border-[#8EB69B]/35 hover:shadow-[0_24px_60px_rgba(0,0,0,0.3)]">
                        <div class="mb-4 flex flex-wrap gap-2">
                            @foreach ($service['tags'] as $tag)
                                <span class="rounded-full px-2.5 py-1 text-[0.7rem] font-semibold tracking-[0.04em] {{ $tag['class'] }}">
                                    {{ $tag['label'] }}
                                </span>
                            @endforeach
                        </div>

                        <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="mb-4 h-[150px] w-full rounded-xl object-cover saturate-[0.6] transition duration-300 group-hover:saturate-100">

                        <h3 class="mb-2 font-['Playfair_Display'] text-[1.3rem] font-bold leading-tight text-white">{{ $service['title'] }}</h3>
                        <p class="mb-5 text-[0.82rem] leading-7 text-white/50">{{ $service['desc'] }}</p>

                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-[0.82rem] font-semibold text-[#8EB69B] transition group-hover:gap-3">
                            Lire plus
                            <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <span class="pointer-events-none absolute inset-x-0 bottom-0 h-[3px] bg-gradient-to-r from-[#235347] to-[#8EB69B] opacity-0 transition group-hover:opacity-100"></span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="points" class="bg-[#F7F5F0] px-6 py-24 lg:px-10">
        <div class="mx-auto max-w-7xl">
            <div class="reveal mb-4 text-center">
                <span class="inline-block text-xs font-semibold uppercase tracking-[0.12em] text-[#235347]">Innovation solidaire</span>
            </div>
            <h2 class="reveal mx-auto mb-5 max-w-4xl text-center font-['Playfair_Display'] text-4xl font-bold leading-[1.15] text-[#0D1F1E] sm:text-5xl">
                Le <span class="text-[#235347]">Systeme de Points</span> pour soigner sans barriere financiere
            </h2>
            <p class="reveal mx-auto max-w-3xl text-center text-base leading-8 text-[#3A5A52]">
                Gagnez des points en aidant votre communaute, et depensez-les pour acceder aux soins dont vous avez besoin.
            </p>

            <div class="mt-14 grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
                <div class="reveal relative overflow-hidden rounded-3xl bg-[#051F20] px-8 py-10">
                    <div class="pointer-events-none absolute -right-14 -top-14 h-64 w-64 rounded-full bg-[radial-gradient(circle,_rgba(35,83,71,0.5)_0%,_transparent_70%)]"></div>

                    <div class="relative mx-auto mb-9 flex h-40 w-40 items-center justify-center rounded-full bg-[conic-gradient(#8EB69B_0%_72%,rgba(255,255,255,0.08)_72%)]">
                        <div class="flex h-[120px] w-[120px] flex-col items-center justify-center rounded-full bg-[#0B2B26]">
                            <span class="font-['Playfair_Display'] text-[1.8rem] font-bold leading-none text-[#8EB69B]">750</span>
                            <span class="mt-1 text-[0.7rem] text-white/50">points</span>
                        </div>
                    </div>

                    <div class="relative space-y-3.5">
                        <div class="flex items-center gap-3.5 rounded-xl bg-white/5 px-4 py-3.5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#235347]">
                                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] fill-white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                                </svg>
                            </div>
                            <div class="text-sm text-white/70"><strong class="block font-semibold text-white">+50 pts</strong>Aide a un autre patient</div>
                        </div>

                        <div class="flex items-center gap-3.5 rounded-xl bg-white/5 px-4 py-3.5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#235347]">
                                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] fill-white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                </svg>
                            </div>
                            <div class="text-sm text-white/70"><strong class="block font-semibold text-white">+30 pts</strong>Participation a un atelier</div>
                        </div>

                        <div class="flex items-center gap-3.5 rounded-xl bg-white/5 px-4 py-3.5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[#235347]">
                                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] fill-white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                                </svg>
                            </div>
                            <div class="text-sm text-white/70"><strong class="block font-semibold text-white">+20 pts</strong>Visionnage d'une video educative</div>
                        </div>
                    </div>
                </div>

                <div class="reveal">
                    <div class="mb-5 rounded-[20px] bg-white p-8">
                        <h3 class="mb-5 font-['Playfair_Display'] text-[1.2rem] font-bold text-[#235347]">Gagner des points</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Aider d'autres patients dans leur parcours</li>
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Participer a des activites associatives</li>
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Assister a des ateliers de sensibilisation</li>
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Completer votre dossier personnel</li>
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Encourager d'autres membres de la communaute</li>
                        </ul>
                    </div>

                    <div class="rounded-[20px] bg-white p-8">
                        <h3 class="mb-5 font-['Playfair_Display'] text-[1.2rem] font-bold text-[#0D1F1E]">Depenser des points</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Consultations medicales et psychologiques</li>
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Acces aux ateliers specialises</li>
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Suivi personnalise avec un therapeute</li>
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Acces aux ressources educatives premium</li>
                            <li class="flex items-start gap-3 text-[0.88rem] text-[#3A5A52]"><span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-[#8EB69B]"></span>Seances de groupe et accompagnement social</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="actors" class="bg-white px-6 py-24 lg:px-10">
        <div class="mx-auto max-w-7xl">
            <div class="reveal text-center">
                <span class="mb-3 inline-block text-xs font-semibold uppercase tracking-[0.12em] text-[#235347]">Notre communaute</span>
                <h2 class="mb-5 font-['Playfair_Display'] text-4xl font-bold leading-[1.15] text-[#0D1F1E] sm:text-5xl">
                    Qui fait partie de <span class="text-[#235347]">Second Chance</span> ?
                </h2>
                <p class="mx-auto max-w-3xl text-base leading-8 text-[#3A5A52]">
                    Quatre types d'acteurs collaborent pour offrir un accompagnement complet et solidaire.
                </p>
            </div>

            <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($actors as $actor)
                    <article class="reveal rounded-[20px] border-2 p-9 text-center transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(5,31,32,0.08)] {{ $actor['card'] }}">
                        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-[18px] {{ $actor['icon'] }}">
                            @if ($actor['svg'] === 'patient')
                                <svg viewBox="0 0 24 24" class="h-7 w-7 fill-white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            @elseif ($actor['svg'] === 'medecin')
                                <svg viewBox="0 0 24 24" class="h-7 w-7 fill-white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
                                </svg>
                            @elseif ($actor['svg'] === 'association')
                                <svg viewBox="0 0 24 24" class="h-7 w-7 fill-white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                </svg>
                            @else
                                <svg viewBox="0 0 24 24" class="h-7 w-7 fill-white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                                </svg>
                            @endif
                        </div>

                        <h3 class="mb-3 font-['Playfair_Display'] text-[1.15rem] font-bold">{{ $actor['title'] }}</h3>
                        <p class="text-[0.82rem] leading-7 {{ $actor['title'] === 'Administrateur' ? 'text-white/55' : 'text-[#3A5A52]' }}">
                            {{ $actor['desc'] }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contact" class="relative overflow-hidden bg-[#163832] px-6 py-24 text-center lg:px-10">
        <div class="pointer-events-none absolute left-1/2 top-[-9rem] h-[37.5rem] w-[37.5rem] -translate-x-1/2 rounded-full bg-[radial-gradient(circle,_rgba(35,83,71,0.5)_0%,_transparent_70%)]"></div>

        <div class="reveal relative mx-auto max-w-4xl">
            <span class="mb-3 inline-block text-xs font-semibold uppercase tracking-[0.12em] text-[#8EB69B]">Commencez aujourd'hui</span>
            <h2 class="mb-4 font-['Playfair_Display'] text-4xl font-bold leading-[1.15] text-white sm:text-5xl">
                Pret a ecrire votre nouveau chapitre ?
            </h2>
            <p class="mx-auto mb-10 max-w-3xl text-base leading-8 text-white/55">
                Rejoignez des centaines de personnes qui ont trouve leur chemin vers la guerison grace a Second Chance. C'est gratuit, confidentiel, et vous n'etes jamais seul.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full bg-[#8EB69B] px-8 py-3.5 text-[0.95rem] font-bold text-[#051F20] transition hover:-translate-y-0.5 hover:bg-white hover:shadow-[0_12px_32px_rgba(142,182,155,0.3)]">
                    S'inscrire gratuitement
                </a>
                <a href="{{ route('login') }}" class="rounded-full border border-white/30 px-8 py-3.5 text-[0.95rem] font-medium text-white transition hover:border-[#8EB69B] hover:text-[#8EB69B]">
                    Parler a un expert
                </a>
            </div>
        </div>
    </section>

    <footer class="border-t border-[#8EB69B]/10 bg-[#051F20] px-6 pb-9 pt-14 lg:px-10">
        <div class="mx-auto max-w-7xl">
            <div class="mb-8 grid gap-10 border-b border-white/10 pb-10 md:grid-cols-2 xl:grid-cols-[2fr_1fr_1fr_1fr]">
                <div>
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-[10px] bg-[#235347]">
                            <svg viewBox="0 0 24 24" class="h-[22px] w-[22px] fill-[#DAF1DE]" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                            </svg>
                        </span>
                        <span class="font-['Playfair_Display'] text-[1.3rem] font-bold tracking-[0.02em] text-white">
                            Second<span class="text-[#8EB69B]">Chance</span>
                        </span>
                    </a>
                    <p class="mt-4 max-w-xs text-[0.85rem] leading-7 text-white/45">
                        Une plateforme numerique solidaire dediee a l'accompagnement des personnes souffrant d'addiction, combinant suivi medical, social et entraide communautaire.
                    </p>
                </div>

                <div>
                    <h4 class="mb-4 text-[0.78rem] font-bold uppercase tracking-[0.1em] text-[#8EB69B]">Navigation</h4>
                    <ul class="space-y-2.5 text-[0.85rem] text-white/45">
                        <li><a href="#home" class="transition hover:text-[#8EB69B]">Accueil</a></li>
                        <li><a href="#about" class="transition hover:text-[#8EB69B]">A propos</a></li>
                        <li><a href="#services" class="transition hover:text-[#8EB69B]">Services</a></li>
                        <li><a href="{{ route('activites.index') }}" class="transition hover:text-[#8EB69B]">Activites</a></li>
                        <li><a href="#contact" class="transition hover:text-[#8EB69B]">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="mb-4 text-[0.78rem] font-bold uppercase tracking-[0.1em] text-[#8EB69B]">Pour qui ?</h4>
                    <ul class="space-y-2.5 text-[0.85rem] text-white/45">
                        <li><a href="{{ route('register') }}" class="transition hover:text-[#8EB69B]">Patients</a></li>
                        <li><a href="{{ route('register') }}" class="transition hover:text-[#8EB69B]">Medecins</a></li>
                        <li><a href="{{ route('register') }}" class="transition hover:text-[#8EB69B]">Associations</a></li>
                        <li><a href="{{ route('dashboard') }}" class="transition hover:text-[#8EB69B]">Administrateurs</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="mb-4 text-[0.78rem] font-bold uppercase tracking-[0.1em] text-[#8EB69B]">Acces rapide</h4>
                    <ul class="space-y-2.5 text-[0.85rem] text-white/45">
                        <li><a href="{{ route('login') }}" class="transition hover:text-[#8EB69B]">Connexion</a></li>
                        <li><a href="{{ route('register') }}" class="transition hover:text-[#8EB69B]">Inscription</a></li>
                        <li><a href="{{ auth()->check() ? route('rendezvous.index') : route('login') }}" class="transition hover:text-[#8EB69B]">Rendez-vous</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="transition hover:text-[#8EB69B]">Profil</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col gap-2 text-center md:flex-row md:items-center md:justify-between md:text-left">
                <p class="text-[0.8rem] text-white/30">© 2025-2026 <span class="text-[#8EB69B]">Second Chance</span> - Projet Fil Rouge YouCode</p>
                <p class="text-[0.8rem] text-white/30">Developpe par <span class="text-[#8EB69B]">FatimaEzzahra Belissaoui</span></p>
            </div>
        </div>
    </footer>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('translate-y-6', 'opacity-0');
                    entry.target.classList.add('translate-y-0', 'opacity-100');
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.reveal').forEach((element) => {
            element.classList.add('translate-y-6', 'opacity-0', 'transition', 'duration-700');
            observer.observe(element);
        });
    </script>
</body>
</html>
