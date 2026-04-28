<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Second Chance - Mon profil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js'])
</head>
<body>
@php
    $user = $user ?? auth()->user();
    $initials = strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1));
@endphp

<div class="layout">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <span class="sidebar-logo-text">Second<span>Chance</span></span>
        </a>

        @if ($user->hasRole('patient'))
            <span class="sidebar-section">Principal</span>
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Tableau de bord
            </a>
            <a href="{{ route('rendezvous.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-7h-5v5h5v-5z"/></svg>Rendez-vous
            </a>
            <a href="{{ route('activites.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>Activites
            </a>
            <a href="{{ route('messages.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm0 14H5.17L4 17.17V4h16v12z"/></svg>Messagerie
            </a>
            <a href="{{ route('patient.dossier') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>Mon dossier
            </a>
        @elseif ($user->hasRole('medecin'))
            <span class="sidebar-section">Medecin</span>
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Tableau de bord
            </a>
            <a href="{{ route('rendezvous.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-7h-5v5h5v-5z"/></svg>Rendez-vous
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link active">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg>Mon profil
            </a>
        @elseif ($user->hasRole('admin'))
            <span class="sidebar-section">Administration</span>
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Dashboard admin
            </a>
            <a href="{{ route('rendezvous.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-7h-5v5h5v-5z"/></svg>Rendez-vous
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link active">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg>Mon profil
            </a>
        @elseif ($user->hasRole('association'))
            <span class="sidebar-section">Association</span>
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Tableau de bord
            </a>
            <a href="{{ route('activites.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>Mes activites
            </a>
            <a href="{{ route('messages.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm0 14H5.17L4 17.17V4h16v12z"/></svg>Messagerie
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link active">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg>Mon profil
            </a>
        @endif

        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="sidebar-avatar">{{ $initials ?: 'SC' }}</div>
                <div>
                    <div class="sidebar-user-name">{{ $user->prenom }} {{ $user->nom }}</div>
                    <div class="sidebar-user-role">{{ ucfirst($user->role) }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Se deconnecter</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="page-header">
            <div>
                <div class="page-title">Mon profil</div>
                <div class="page-subtitle">Retrouvez vos réglages personnels dans la même interface que le reste de la plateforme.</div>
            </div>
            <div class="header-right">
                <a href="{{ route('dashboard') }}" class="btn-outline">Retour dashboard</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="stats-row" style="grid-template-columns:repeat(3,1fr);">
            <div class="stat-card">
                <div class="stat-card-top">
                    <span class="stat-badge sb-up">Compte</span>
                </div>
                <div class="stat-val" style="font-size:1.45rem;">{{ ucfirst($user->role) }}</div>
                <div class="stat-lbl">Type de profil</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-top">
                    <span class="stat-badge sb-up">Email</span>
                </div>
                <div class="stat-val" style="font-size:1.1rem;line-height:1.3;">{{ $user->email }}</div>
                <div class="stat-lbl">Adresse principale</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-top">
                    <span class="stat-badge sb-warn">Sécurité</span>
                </div>
                <div class="stat-val" style="font-size:1.1rem;line-height:1.3;">
                    {{ $user->email_verified_at ? 'Vérifié' : 'À vérifier' }}
                </div>
                <div class="stat-lbl">État du compte</div>
            </div>
        </div>

        <div class="dashboard-grid" style="grid-template-columns:1.2fr .8fr;">
            <div>
                <div class="card" style="margin-bottom:24px;">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="card">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div>
                <div class="card" style="margin-bottom:24px;">
                    <div class="card-header">
                        <span class="card-title">Résumé du compte</span>
                    </div>
                    <div class="msg-item">
                        <div class="msg-avatar">{{ $initials ?: 'SC' }}</div>
                        <div style="flex:1;min-width:0;">
                            <div class="msg-name">{{ trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')) ?: ($user->name ?? 'Utilisateur') }}</div>
                            <div class="msg-preview">{{ ucfirst($user->role) }} · {{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background:var(--gm);">
                            <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                        </div>
                        <div>
                            <div class="activity-name">Nom affiché</div>
                            <div class="activity-meta">{{ trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')) ?: 'Non renseigné' }}</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background:#2D7A65;">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </div>
                        <div>
                            <div class="activity-name">Email</div>
                            <div class="activity-meta">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="card" style="background:linear-gradient(180deg,#fffafa 0%,#fff4f4 100%); border:1px solid #f3d6d6;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
