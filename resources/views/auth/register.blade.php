<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Second Chance - Inscription</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/register.js'])
</head>
<body class="min-h-screen bg-[#F4F7F5] font-['DM_Sans'] text-[#0D1F1E]">
    @php
        $roles = [
            [
                'key' => 'patient',
                'emoji' => '',
                'title' => 'Patient',
                'desc' => 'Je cherche un accompagnement medical et social pour surmonter mon addiction.',
            ],
            [
                'key' => 'medecin',
                'emoji' => '',
                'title' => 'Medecin / Psychologue',
                'desc' => 'Je suis professionnel de sante et je souhaite aider des patients.',
            ],
            [
                'key' => 'association',
                'emoji' => '',
                'title' => 'Association',
                'desc' => 'Nous organisons des activites et ateliers de soutien communautaire.',
            ],
        ];

        $cities = ['Casablanca', 'Rabat', 'Marrakech', 'Fes', 'Tanger', 'Kenitra', 'Autre'];
        $selectedRole = old('role', 'patient');
        $selectedAddictions = array_filter(array_map('trim', explode(',', old('type_addiction', ''))));

        $checkIcon = '<svg viewBox="0 0 24 24" class="h-3.5 w-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>';
        $documentIcon = '<svg viewBox="0 0 24 24" class="h-8 w-8 fill-[#235347]" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm0 2.5L18.5 9H14zM8 13h8v2H8zm0 4h8v2H8zm0-8h4v2H8z"/></svg>';
        $clipboardIcon = '<svg viewBox="0 0 24 24" class="h-8 w-8 fill-[#235347]" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M19 3h-3.2A3 3 0 0 0 13 1h-2a3 3 0 0 0-2.8 2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2M12 3a1 1 0 0 1 1 1h-2a1 1 0 0 1 1-1m5 16H7V5h2v2h6V5h2zM9 10h6v2H9zm0 4h6v2H9z"/></svg>';
        $eyeIcon = '<svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 5c-5 0-9.3 3.1-11 7 1.7 3.9 6 7 11 7s9.3-3.1 11-7c-1.7-3.9-6-7-11-7m0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8m0-6.4A2.4 2.4 0 1 0 12 14a2.4 2.4 0 0 0 0-4.4"/></svg>';
        $crossIcon = '<svg viewBox="0 0 24 24" class="h-3.5 w-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M19 6.4 17.6 5 12 10.6 6.4 5 5 6.4l5.6 5.6L5 17.6 6.4 19l5.6-5.6 5.6 5.6 1.4-1.4-5.6-5.6z"/></svg>';
    @endphp

    <nav class="flex items-center justify-between bg-[#051F20] px-6 py-4 lg:px-14">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-[9px] bg-[#235347]">
                <svg viewBox="0 0 24 24" class="h-[18px] w-[18px] fill-[#DAF1DE]" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                </svg>
            </span>
            <span class="font-['Playfair_Display'] text-[1.2rem] font-bold text-white">
                Second<span class="text-[#8EB69B]">Chance</span>
            </span>
        </a>

        <span class="text-sm text-white/55">
            Deja membre ?
            <a href="{{ route('login') }}" class="font-semibold text-[#8EB69B]">Se connecter</a>
        </span>
    </nav>

    <header class="border-b border-[#E5EDEA] bg-white px-6 py-5 lg:px-14">
        <div class="mx-auto flex max-w-[700px] items-center">
            @for ($step = 1; $step <= 5; $step++)
                <div class="flex flex-1 items-center gap-2.5">
                    <div id="sc{{ $step }}" class="{{ $step === 1 ? 'bg-[#235347] text-white shadow-[0_0_0_4px_rgba(35,83,71,0.2)]' : 'bg-[#EEF3F0] text-[#7A9E93]' }} flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-[0.87rem] font-bold transition-all">
                        {{ $step }}
                    </div>
                    <span id="sl{{ $step }}" class="{{ $step === 1 ? 'text-[#235347]' : 'text-[#7A9E93]' }} hidden text-[0.78rem] font-semibold sm:inline">
                        @switch($step)
                            @case(1) Role @break
                            @case(2) Identite @break
                            @case(3) Profil @break
                            @case(4) Securite @break
                            @default Confirmation
                        @endswitch
                    </span>
                </div>
                @if ($step < 5)
                    <div id="line{{ $step }}" class="mx-2 h-0.5 flex-1 bg-[#EEF3F0]"></div>
                @endif
            @endfor
        </div>
    </header>

    <main class="flex flex-1 items-center justify-center px-6 py-12">
        <div class="w-full max-w-3xl rounded-3xl bg-white px-6 py-8 shadow-[0_8px_40px_rgba(5,31,32,0.09)] sm:px-8 lg:px-12">
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-[#E05C5C]/20 bg-[#E05C5C]/10 px-5 py-4 text-sm text-[#8B2F2F]">
                    <p class="font-semibold">Le formulaire contient des erreurs.</p>
                    <ul class="mt-2 list-disc ps-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <a href="{{ route('auth.google.redirect') }}" class="mb-6 flex w-full items-center justify-center gap-3 rounded-full border border-[#D9E8E0] bg-white px-4 py-3 text-sm font-semibold text-[#3A5A52] transition hover:border-[#235347] hover:text-[#235347]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="h-5 w-5">
                    <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12S17.4 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.3-.4-3.5z"/>
                    <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 18.9 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                    <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.3 0-9.8-3.3-11.5-8l-6.5 5C9.3 39.6 16.1 44 24 44z"/>
                    <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.1 5.6l.1-.1 6.2 5.2C37 38.4 44 33 44 24c0-1.3-.1-2.3-.4-3.5z"/>
                </svg>
                S'inscrire avec Google
            </a>

            <div class="mb-6 flex items-center gap-3 text-xs text-[#7A9E93]">
                <span class="h-px flex-1 bg-[#D9E8E0]"></span>
                <span>ou avec email</span>
                <span class="h-px flex-1 bg-[#D9E8E0]"></span>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm" data-has-errors="{{ $errors->any() ? 'true' : 'false' }}" novalidate>
                @csrf
                <input type="hidden" name="role" id="roleInput" value="{{ $selectedRole }}">

                <section id="p1" class="panel active">
                    <h1 class="mb-2 font-['Playfair_Display'] text-3xl font-bold text-[#0D1F1E]">Qui etes-vous ?</h1>
                    <p class="mb-8 text-sm leading-7 text-[#7A9E93]">Choisissez votre role pour personnaliser votre experience sur Second Chance.</p>

                    <div class="mb-7 grid gap-4 md:grid-cols-2">
                        @foreach ($roles as $role)
                            <button
                                type="button"
                                data-role="{{ $role['key'] }}"
                                class="role-card relative rounded-2xl border-2 px-5 py-6 text-center transition {{ $selectedRole === $role['key'] ? 'border-[#235347] bg-[#DAF1DE]' : 'border-[#D9E8E0] bg-white hover:border-[#235347] hover:bg-[#DAF1DE]' }}"
                            >
                                <span class="mb-3 block text-4xl">{{ $role['emoji'] }}</span>
                                <span class="mb-1 block text-[0.95rem] font-bold text-[#0D1F1E]">{{ $role['title'] }}</span>
                                <span class="block text-xs leading-5 text-[#7A9E93]">{{ $role['desc'] }}</span>
                                <span class="{{ $selectedRole === $role['key'] ? 'flex' : 'hidden' }} role-check absolute right-3 top-3 h-6 w-6 items-center justify-center rounded-full bg-[#235347] text-white">
                                    {!! $checkIcon !!}
                                </span>
                            </button>
                        @endforeach
                    </div>

                    <div class="mt-7 flex items-center justify-between gap-4">
                        <div></div>
                        <button type="button" class="rounded-full bg-[#235347] px-7 py-3 text-sm font-bold text-white transition hover:bg-[#8EB69B] hover:text-[#051F20]" data-next="2">
                            Continuer ->
                        </button>
                    </div>

                    <p class="mt-5 text-center text-sm text-[#7A9E93]">
                        Deja inscrit ?
                        <a href="{{ route('login') }}" class="font-semibold text-[#235347]">Se connecter</a>
                    </p>
                </section>

                <section id="p2" class="panel hidden">
                    <h2 class="mb-2 font-['Playfair_Display'] text-3xl font-bold text-[#0D1F1E]">Vos informations</h2>
                    <p class="mb-8 text-sm leading-7 text-[#7A9E93]">Renseignez vos informations personnelles. Tout est strictement confidentiel.</p>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="mb-4">
                            <label for="prenom" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Prenom <span class="text-[#E05C5C]">*</span></label>
                            <input id="prenom" name="prenom" type="text" value="{{ old('prenom') }}" placeholder="Fatima" class="@error('prenom') border-[#E05C5C] @else border-[#D9E8E0] @enderror w-full rounded-[10px] border px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                        </div>

                        <div class="mb-4">
                            <label for="nom" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Nom <span class="text-[#E05C5C]">*</span></label>
                            <input id="nom" name="nom" type="text" value="{{ old('nom') }}" placeholder="Belissaoui" class="@error('nom') border-[#E05C5C] @else border-[#D9E8E0] @enderror w-full rounded-[10px] border px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Adresse email <span class="text-[#E05C5C]">*</span></label>
                        <div class="relative">
                            <svg viewBox="0 0 24 24" class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 fill-[#7A9E93]" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="votre@email.com" class="@error('email') border-[#E05C5C] @else border-[#D9E8E0] @enderror w-full rounded-[10px] border py-3 pl-11 pr-4 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="mb-4">
                            <label for="telephone" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Telephone</label>
                            <div class="relative">
                                <svg viewBox="0 0 24 24" class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 fill-[#7A9E93]" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                                <input id="telephone" name="telephone" type="tel" value="{{ old('telephone') }}" placeholder="+212 6XX XXX XXX" class="w-full rounded-[10px] border border-[#D9E8E0] py-3 pl-11 pr-4 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="date_naissance" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Date de naissance</label>
                            <input id="date_naissance" name="date_naissance" type="date" value="{{ old('date_naissance') }}" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="mb-4">
                            <label for="ville" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Ville <span class="text-[#E05C5C]">*</span></label>
                            <select id="ville" name="ville" class="@error('ville') border-[#E05C5C] @else border-[#D9E8E0] @enderror w-full rounded-[10px] border px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                                <option value="">Selectionner...</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}" @selected(old('ville') === $city)>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="genre" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Genre</label>
                            <select id="genre" name="genre" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                                <option value="">Preferez ne pas dire</option>
                                <option value="Homme" @selected(old('genre') === 'Homme')>Homme</option>
                                <option value="Femme" @selected(old('genre') === 'Femme')>Femme</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-7 flex items-center justify-between gap-4">
                        <button type="button" class="rounded-full border border-[#D9E8E0] px-7 py-3 text-sm text-[#3A5A52] transition hover:border-[#235347] hover:text-[#235347]" data-prev="1">
                            <- Retour
                        </button>
                        <button type="button" class="rounded-full bg-[#235347] px-7 py-3 text-sm font-bold text-white transition hover:bg-[#8EB69B] hover:text-[#051F20]" data-next="3">
                            Continuer ->
                        </button>
                    </div>
                </section>

                <section id="p3" class="panel hidden">
                    <h2 class="mb-2 font-['Playfair_Display'] text-3xl font-bold text-[#0D1F1E]">Votre profil</h2>
                    <p id="p3sub" class="mb-8 text-sm leading-7 text-[#7A9E93]">Parlez-nous de vous pour que nous puissions personnaliser votre accompagnement.</p>

                    <div id="patient-fields" class="{{ $selectedRole === 'patient' ? '' : 'hidden' }}">
                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Type d'addiction concernee</label>
                            <input type="hidden" name="type_addiction" id="patientTypeAddiction" value="{{ old('type_addiction') }}">
                            <div class="flex flex-wrap gap-2">
                                @foreach (['Alcool', 'Tabac', 'Drogue', 'Jeux video', 'Jeux d argent', 'Reseaux sociaux', 'Alimentation', 'Autre'] as $tag)
                                    <button type="button" data-tag-group="patient" data-tag-target="patientTypeAddiction" data-tag-value="{{ $tag }}" class="tag-btn rounded-full border px-4 py-2 text-xs transition hover:border-[#235347] hover:bg-[#DAF1DE] {{ in_array($tag, $selectedAddictions, true) ? 'border-[#235347] bg-[#235347] text-white' : 'border-[#D9E8E0] text-[#3A5A52]' }}">
                                        {{ $tag }}
                                    </button>
                                @endforeach
                            </div>
                            <p class="mt-2 text-xs text-[#7A9E93]">Vous pouvez selectionner plusieurs options.</p>
                        </div>

                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Depuis combien de temps ?</label>
                            <select name="duree_addiction" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                                <option value="">Choisir</option>
                                <option value="moins_6_mois">Moins de 6 mois</option>
                                <option value="6_mois_1_an">6 mois - 1 an</option>
                                <option value="1_3_ans">1 - 3 ans</option>
                                <option value="plus_3_ans">Plus de 3 ans</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Avez-vous deja suivi un traitement ?</label>
                            <select name="traitement" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                                <option value="premiere_fois">Non, c'est la premiere fois</option>
                                <option value="en_cours">Oui, en cours</option>
                                <option value="termine">Oui, termine</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="description" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Partagez votre situation</label>
                            <textarea id="description" name="description" rows="4" placeholder="Decrivez brievement votre situation pour nous aider a mieux vous accompagner..." class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20"></textarea>
                        </div>
                    </div>

                    <div id="medecin-fields" class="{{ $selectedRole === 'medecin' ? '' : 'hidden' }}">
                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Specialite</label>
                            <input type="hidden" name="specialite" id="medecinSpecialite" value="{{ old('specialite') }}">
                            <div class="flex flex-wrap gap-2">
                                @foreach (['Addictologie', 'Psychologie', 'Psychiatrie', 'Medecine generale', 'Sophrologie', 'Autre'] as $tag)
                                    <button type="button" data-tag-group="medecin" data-tag-target="medecinSpecialite" data-tag-value="{{ $tag }}" class="tag-btn rounded-full border px-4 py-2 text-xs transition hover:border-[#235347] hover:bg-[#DAF1DE] {{ old('specialite') === $tag ? 'border-[#235347] bg-[#235347] text-white' : 'border-[#D9E8E0] text-[#3A5A52]' }}">
                                        {{ $tag }}
                                    </button>
                                @endforeach
                            </div>
                            @error('specialite')
                                <p class="mt-2 text-xs text-[#E05C5C]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="mb-5">
                                <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">N° d'ordre medical</label>
                                <input type="text" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20" placeholder="OM-XXXX-XXXX">
                            </div>
                            <div class="mb-5">
                                <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Annees d'experience</label>
                                <select class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                                    <option>Moins de 2 ans</option>
                                    <option>2-5 ans</option>
                                    <option>5-10 ans</option>
                                    <option>Plus de 10 ans</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="appointment_points_cost" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Points par rendez-vous</label>
                            <input
                                id="appointment_points_cost"
                                name="appointment_points_cost"
                                type="number"
                                min="1"
                                step="1"
                                value="{{ old('appointment_points_cost', \App\Models\Medecin::DEFAULT_APPOINTMENT_POINTS_COST) }}"
                                class="@error('appointment_points_cost') border-[#E05C5C] @else border-[#D9E8E0] @enderror w-full rounded-[10px] border px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20"
                                placeholder="{{ \App\Models\Medecin::DEFAULT_APPOINTMENT_POINTS_COST }}"
                            >
                            <p class="mt-2 text-xs text-[#7A9E93]">Ce nombre sera le cout demande au patient pour confirmer un rendez-vous avec ce medecin.</p>
                            @error('appointment_points_cost')
                                <p class="mt-2 text-xs text-[#E05C5C]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5 rounded-xl border-2 border-dashed border-[#D9E8E0] bg-[#F4F7F5] px-6 py-8 text-center transition hover:border-[#235347] hover:bg-[#DAF1DE]">
                            <div class="mb-2 flex justify-center">{!! $documentIcon !!}</div>
                            <p class="text-sm font-medium text-[#3A5A52]">Glisser votre document ici</p>
                            <p class="mt-1 text-xs text-[#7A9E93]">PDF, JPG, PNG · Max 5MB</p>
                        </div>

                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Biographie professionnelle</label>
                            <textarea rows="4" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20" placeholder="Decrivez votre parcours et votre approche therapeutique..."></textarea>
                        </div>
                    </div>

                    <div id="assoc-fields" class="{{ $selectedRole === 'association' ? '' : 'hidden' }}">
                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Nom de l'association</label>
                            <input type="text" name="association_nom" value="{{ old('association_nom') }}" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20" placeholder="Association Espoir Maroc">
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="mb-5">
                                <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Numero d'agrement</label>
                                <input type="text" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20" placeholder="AG-XXXX">
                            </div>
                            <div class="mb-5">
                                <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Fondee en</label>
                                <input type="number" min="1900" max="2026" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20" placeholder="2015">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Description des activites</label>
                            <textarea name="association_description" rows="4" class="w-full rounded-[10px] border border-[#D9E8E0] px-4 py-3 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20" placeholder="Decrivez vos missions et activites principales...">{{ old('association_description') }}</textarea>
                        </div>

                        <div class="mb-5 rounded-xl border-2 border-dashed border-[#D9E8E0] bg-[#F4F7F5] px-6 py-8 text-center transition hover:border-[#235347] hover:bg-[#DAF1DE]">
                            <div class="mb-2 flex justify-center">{!! $clipboardIcon !!}</div>
                            <p class="text-sm font-medium text-[#3A5A52]">Deposer le recepisse officiel</p>
                            <p class="mt-1 text-xs text-[#7A9E93]">PDF, JPG, PNG · Max 5MB</p>
                        </div>
                    </div>

                    <div class="mt-7 flex items-center justify-between gap-4">
                        <button type="button" class="rounded-full border border-[#D9E8E0] px-7 py-3 text-sm text-[#3A5A52] transition hover:border-[#235347] hover:text-[#235347]" data-prev="2">
                            <- Retour
                        </button>
                        <button type="button" class="rounded-full bg-[#235347] px-7 py-3 text-sm font-bold text-white transition hover:bg-[#8EB69B] hover:text-[#051F20]" data-next="4">
                            Continuer ->
                        </button>
                    </div>
                </section>

                <section id="p4" class="panel hidden">
                    <h2 class="mb-2 font-['Playfair_Display'] text-3xl font-bold text-[#0D1F1E]">Securite du compte</h2>
                    <p class="mb-8 text-sm leading-7 text-[#7A9E93]">Creez un mot de passe fort pour proteger votre compte et vos donnees.</p>

                    <div class="mb-5">
                        <label for="password" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Mot de passe <span class="text-[#E05C5C]">*</span></label>
                        <div class="relative">
                            <svg viewBox="0 0 24 24" class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 fill-[#7A9E93]" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                            </svg>
                            <input id="password" name="password" type="password" placeholder="Minimum 8 caracteres" class="@error('password') border-[#E05C5C] @else border-[#D9E8E0] @enderror w-full rounded-[10px] border py-3 pl-11 pr-11 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                            <button type="button" data-toggle-password="password" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#7A9E93]" aria-label="Afficher ou masquer le mot de passe">
                                <span class="pointer-events-none password-toggle-icon">{!! $eyeIcon !!}</span>
                            </button>
                        </div>

                        <div class="mt-3">
                            <div class="mb-2 flex gap-1">
                                <span id="seg1" class="h-1 w-full rounded bg-[#EEF3F0]"></span>
                                <span id="seg2" class="h-1 w-full rounded bg-[#EEF3F0]"></span>
                                <span id="seg3" class="h-1 w-full rounded bg-[#EEF3F0]"></span>
                                <span id="seg4" class="h-1 w-full rounded bg-[#EEF3F0]"></span>
                            </div>
                            <p id="strengthLabel" class="text-xs text-[#7A9E93]">Entrez un mot de passe</p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-[#0D1F1E]">Confirmer le mot de passe <span class="text-[#E05C5C]">*</span></label>
                        <div class="relative">
                            <svg viewBox="0 0 24 24" class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 fill-[#7A9E93]" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                            </svg>
                            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Repetez le mot de passe" class="w-full rounded-[10px] border border-[#D9E8E0] py-3 pl-11 pr-11 text-sm outline-none transition focus:border-[#8EB69B] focus:ring-4 focus:ring-[#8EB69B]/20">
                            <button type="button" data-toggle-password="password_confirmation" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#7A9E93]" aria-label="Afficher ou masquer la confirmation du mot de passe">
                                <span class="pointer-events-none password-toggle-icon">{!! $eyeIcon !!}</span>
                            </button>
                        </div>
                    </div>

                    <div class="mb-5 rounded-xl bg-[#DAF1DE] px-5 py-4">
                        <p class="mb-3 text-xs font-bold text-[#235347]">Le mot de passe doit contenir :</p>
                        <div class="grid gap-2 text-xs text-[#7A9E93] sm:grid-cols-2">
                            <p id="r-len" data-rule-label="Au moins 8 caracteres" class="flex items-center gap-2">
                                <span class="rule-icon text-[#7A9E93]">{!! $crossIcon !!}</span>
                                <span>Au moins 8 caracteres</span>
                            </p>
                            <p id="r-upper" data-rule-label="Une majuscule" class="flex items-center gap-2">
                                <span class="rule-icon text-[#7A9E93]">{!! $crossIcon !!}</span>
                                <span>Une majuscule</span>
                            </p>
                            <p id="r-num" data-rule-label="Un chiffre" class="flex items-center gap-2">
                                <span class="rule-icon text-[#7A9E93]">{!! $crossIcon !!}</span>
                                <span>Un chiffre</span>
                            </p>
                            <p id="r-spec" data-rule-label="Un caractere special" class="flex items-center gap-2">
                                <span class="rule-icon text-[#7A9E93]">{!! $crossIcon !!}</span>
                                <span>Un caractere special</span>
                            </p>
                        </div>
                    </div>

                    <label class="mb-4 flex items-start gap-3 text-sm leading-6 text-[#3A5A52]">
                        <input id="terms" type="checkbox" class="mt-1 h-4 w-4 accent-[#235347]">
                        <span>J'accepte les <a href="{{ url('/') }}" class="font-semibold text-[#235347]">Conditions d'utilisation</a> et la <a href="{{ url('/') }}" class="font-semibold text-[#235347]">Politique de confidentialite</a>.</span>
                    </label>

                    <label class="mb-4 flex items-start gap-3 text-sm leading-6 text-[#3A5A52]">
                        <input id="rgpd" type="checkbox" class="mt-1 h-4 w-4 accent-[#235347]">
                        <span>Je comprends que mes donnees sont traitees de facon confidentielle conformement au <a href="{{ url('/') }}" class="font-semibold text-[#235347]">RGPD</a>.</span>
                    </label>

                    <label class="mb-2 flex items-start gap-3 text-sm leading-6 text-[#3A5A52]">
                        <input id="notif" type="checkbox" class="mt-1 h-4 w-4 accent-[#235347]">
                        <span>Je souhaite recevoir des notifications sur les activites et rendez-vous.</span>
                    </label>

                    <div class="mt-7 flex items-center justify-between gap-4">
                        <button type="button" class="rounded-full border border-[#D9E8E0] px-7 py-3 text-sm text-[#3A5A52] transition hover:border-[#235347] hover:text-[#235347]" data-prev="3">
                            <- Retour
                        </button>
                        <button type="button" class="rounded-full bg-[#235347] px-7 py-3 text-sm font-bold text-white transition hover:bg-[#8EB69B] hover:text-[#051F20]" data-next="5">
                            Continuer ->
                        </button>
                    </div>
                </section>

                <section id="p5" class="panel hidden">
                    <div class="py-4 text-center">
                        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-[#DAF1DE] text-[#235347]">
                            <svg viewBox="0 0 24 24" class="h-10 w-10 fill-current" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/>
                            </svg>
                        </div>
                        <h2 class="mb-3 font-['Playfair_Display'] text-3xl font-bold text-[#0D1F1E]">Confirmation</h2>
                        <p class="mx-auto mb-8 max-w-md text-sm leading-7 text-[#7A9E93]">Verifiez vos informations avant de creer votre compte. Apres l'inscription, vous serez redirige vers votre espace.</p>

                        <div class="mb-8 rounded-2xl bg-[#DAF1DE] px-6 py-5 text-left">
                            <div class="flex items-center justify-between border-b border-[#235347]/10 py-2">
                                <span class="text-sm text-[#7A9E93]">Nom</span>
                                <span id="succName" class="text-sm font-semibold text-[#235347]">-</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-[#235347]/10 py-2">
                                <span class="text-sm text-[#7A9E93]">Role</span>
                                <span id="succRole" class="text-sm font-semibold text-[#235347]">-</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-[#235347]/10 py-2">
                                <span class="text-sm text-[#7A9E93]">Email</span>
                                <span id="succEmail" class="text-sm font-semibold text-[#235347]">-</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-[#7A9E93]">Statut</span>
                                <span class="text-sm font-semibold text-[#E8A838]">Verification email</span>
                            </div>
                        </div>

                        <div class="flex flex-col justify-center gap-4 sm:flex-row">
                            <button type="button" class="rounded-full border border-[#D9E8E0] px-7 py-3 text-sm text-[#3A5A52] transition hover:border-[#235347] hover:text-[#235347]" data-prev="4">
                                <- Retour
                            </button>
                            <button type="submit" class="rounded-full bg-[#235347] px-8 py-3 text-sm font-bold text-white transition hover:bg-[#8EB69B] hover:text-[#051F20]">
                                Creer mon compte ->
                            </button>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </main>

</body>
</html>
