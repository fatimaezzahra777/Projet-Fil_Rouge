<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Second Chance - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
</head>
<body>
@php
    $user = $user ?? auth()->user();
    $initials = strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1));
    $todayLabel = now()->format('d/m/Y');
    $patientNotifications = $patientNotifications ?? collect();
    $patientUnreadNotifications = $patientUnreadNotifications ?? 0;
    $doctorSearch = $doctorSearch ?? '';
    $doctorResults = $doctorResults ?? collect();
@endphp
<div class="layout">
    @if ($user->hasRole('patient'))
        @include('partials.patient-sidebar', ['active' => 'dashboard'])
    @else
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <span class="sidebar-logo-text">Second<span>Chance</span></span>
        </a>

        @if ($user->hasRole('medecin'))
            <span class="sidebar-section">Medecin</span>
            <a href="{{ route('dashboard') }}" class="sidebar-link active">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Tableau de bord
            </a>
            <a href="{{ route('rendezvous.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-7h-5v5h5v-5z"/></svg>Rendez-vous
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg>Mon profil
            </a>
        @elseif ($user->hasRole('admin'))
            <span class="sidebar-section">Administration</span>
            <a href="{{ route('dashboard') }}" class="sidebar-link active">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Dashboard admin
            </a>
            <a href="{{ route('rendezvous.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-7h-5v5h5v-5z"/></svg>Rendez-vous
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg>Mon profil
            </a>
        @elseif ($user->hasRole('association'))
            <span class="sidebar-section">Association</span>
            <a href="{{ route('dashboard') }}" class="sidebar-link active">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Tableau de bord
            </a>
            <a href="{{ route('activites.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>Mes activites
            </a>
            <a href="{{ route('messages.index') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm0 14H5.17L4 17.17V4h16v12z"/></svg>Messagerie
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg>Mon profil
            </a>
        @endif

        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="sidebar-avatar">{{ $initials ?: 'SC' }}</div>
                <div>
                    <div class="sidebar-user-name">{{ $user->prenom }} {{ $user->nom }}</div>
                    <div class="sidebar-user-role">
                        {{ ucfirst($user->role) }}
                        @if ($user->hasRole('patient') && isset($patientStats))
                            · {{ $patientStats['points'] }} pts
                        @endif
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Se deconnecter</button>
            </form>
        </div>
    </aside>
    @endif

    <main class="main">
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

        @if ($user->hasRole('patient') && isset($patientStats))
            <div class="page-header">
                <div>
                    <div class="page-title">Bonjour, {{ $user->prenom }} {{ $user->nom }}</div>
                    <div class="page-subtitle">Voici votre tableau de bord - {{ $todayLabel }}</div>
                </div>
                <div class="header-right">
                    <a href="{{ route('rendezvous.create') }}" class="btn-primary">+ Rendez-vous</a>
                </div>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-badge sb-up">Niveau {{ $patientStats['level_label'] }}</span>
                    </div>
                    <div class="stat-val">{{ $patientStats['points'] }}</div>
                    <div class="stat-lbl">Points disponibles</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        
                        <span class="stat-badge sb-warn">{{ $patientStats['rendezvous_upcoming'] }} a venir</span>
                    </div>
                    <div class="stat-val">{{ $patientStats['rendezvous_total'] }}</div>
                    <div class="stat-lbl">Rendez-vous totaux</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                         <span class="stat-badge sb-up">Actif</span>
                    </div>
                    <div class="stat-val">{{ $patientStats['participations_total'] }}</div>
                    <div class="stat-lbl">Activites suivies</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                         <span class="stat-badge sb-up">Suivi</span>
                    </div>
                    <div class="stat-val">{{ $patientStats['global_progress'] }}%</div>
                    <div class="stat-lbl">Progres global</div>
                </div>
            </div>

            <div class="dashboard-grid">
                <div>
                    <div class="card" style="margin-bottom:24px;">
                        <div class="card-header">
                            <span class="card-title">Prochains rendez-vous</span>
                            <a href="{{ route('rendezvous.index') }}" class="card-action">Voir tout -></a>
                        </div>

                        @forelse ($patientAppointments as $rendezVous)
                            @php
                                $rdvDate = \Illuminate\Support\Carbon::parse($rendezVous->date);
                                $statusClass = match($rendezVous->statut) {
                                    'confirme', 'confirmé' => 'badge-ok',
                                    'annule', 'annulé', 'refuse' => 'badge-cancel',
                                    default => 'badge-pend',
                                };
                                $statusLabel = str_replace('_', ' ', ucfirst($rendezVous->statut));
                            @endphp
                            <div class="rdv-item">
                                <div class="rdv-date">
                                    <div class="rdv-day">{{ $rdvDate->format('d') }}</div>
                                    <div class="rdv-month">{{ $rdvDate->format('M') }}</div>
                                </div>
                                <div class="rdv-info">
                                    <div class="rdv-name">Dr. {{ $rendezVous->medecin?->user?->prenom }} {{ $rendezVous->medecin?->user?->nom }}</div>
                                    <div class="rdv-type">{{ $rendezVous->medecin?->specialite ?: 'Consultation' }}</div>
                                </div>
                                <div style="text-align:right;">
                                    <div class="rdv-time">{{ $rendezVous->heure }}</div>
                                    <span class="badge {{ $statusClass }}" style="margin-top:5px;">{{ $statusLabel }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">Aucun rendez-vous programme pour le moment.</div>
                        @endforelse
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <span class="card-title">Mon progres</span>
                            <span class="card-action">Mise a jour automatique</span>
                        </div>
                        @foreach ($patientProgress as $label => $value)
                            <div class="progress-item">
                                <div class="progress-label"><span>{{ $label }}</span><span>{{ $value }}%</span></div>
                                <div class="progress-bar"><div class="progress-fill" style="width:{{ $value }}%"></div></div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="points-card" style="margin-bottom:24px;">
                        <div style="font-size:.75rem;color:rgba(142,182,155,.6);text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Mes points</div>
                        <div class="points-total">{{ $patientStats['points'] }}</div>
                        <div class="points-lbl">points disponibles</div>
                        <div class="points-bar-wrap">
                            <div class="points-bar-lbl"><span>Niveau {{ $patientStats['level_label'] }}</span><span>{{ $patientStats['next_level_target'] }} pts -> niveau suivant</span></div>
                            <div class="points-bar"><div class="points-bar-fill" style="width:{{ $patientStats['level_progress'] }}%"></div></div>
                        </div>
                        <div class="points-actions">
                            <a href="{{ route('activites.index') }}" class="btn-pts btn-earn">+ Gagner</a>
                            <a href="{{ route('rendezvous.index') }}" class="btn-pts btn-spend">Utiliser</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <span class="card-title">Historique points</span>
                            <span class="card-action">{{ $patientTransactions->count() }} recentes</span>
                        </div>
                        @forelse ($patientTransactions as $transaction)
                            @php
                                $isEarn = $transaction->type === 'gain';
                            @endphp
                            <div class="history-item">
                                <div class="history-dot {{ $isEarn ? 'earn' : 'spend' }}"></div>
                                <div class="history-info">
                                    <div class="history-desc">{{ $transaction->description }}</div>
                                    <div class="history-date">{{ $transaction->created_at?->format('d/m/Y H:i') }}</div>
                                </div>
                                <span class="history-pts {{ $isEarn ? 'earn' : 'spend' }}">{{ $isEarn ? '+' : '-' }}{{ abs($transaction->montant) }}</span>
                            </div>
                        @empty
                            <div class="empty-state">Aucune transaction de points pour le moment.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bottom-grid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Notifications</span>
                        <span class="card-action">{{ $patientUnreadNotifications }} non lue(s)</span>
                    </div>
                    @forelse ($patientNotifications as $notification)
                        @php
                            $data = $notification->data;
                        @endphp
                        <div class="msg-item">
                            <div class="msg-avatar">{{ strtoupper(substr($data['association'] ?? 'A', 0, 2)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div class="msg-name">{{ $data['association'] ?? 'Association' }}</div>
                                <div class="msg-preview">
                                    {{ $data['message'] ?? 'Nouvelle activite disponible.' }}
                                    @if (!empty($data['date']))
                                        · {{ \Illuminate\Support\Carbon::parse($data['date'])->format('d/m/Y') }}
                                    @endif
                                    @if (!empty($data['points']))
                                        · +{{ $data['points'] }} pts
                                    @endif
                                </div>
                            </div>
                            <span class="msg-time">{{ $notification->created_at?->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="empty-state">Aucune notification pour le moment.</div>
                    @endforelse
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Rechercher un medecin</span>
                        <a href="{{ route('rendezvous.create') }}" class="card-action">Prendre rendez-vous -></a>
                    </div>
                    <form method="GET" action="{{ route('dashboard') }}" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:18px;">
                        <input
                            type="text"
                            name="doctor_search"
                            value="{{ $doctorSearch }}"
                            placeholder="Nom, specialite, ville..."
                            style="flex:1;min-width:220px;border:1px solid #d6e2db;border-radius:14px;padding:12px 14px;font:inherit;background:#fff;"
                        >
                        <button type="submit" class="btn-primary" style="border:none;">Rechercher</button>
                    </form>
                    @forelse ($doctorResults as $doctor)
                        <div class="activity-item">
                            <div class="activity-icon" style="background:var(--gm);">
                                <svg viewBox="0 0 24 24"><path d="M19 8h-4V4h-2v4H9v2h4v4h2v-4h4zM5 19h14v2H5z"/></svg>
                            </div>
                            <div style="flex:1;">
                                <div class="activity-name">Dr. {{ $doctor->user?->prenom }} {{ $doctor->user?->nom }}</div>
                                <div class="activity-meta">{{ $doctor->specialite ?: 'Consultation generale' }} · {{ $doctor->user?->ville ?: 'Ville non renseignee' }}</div>
                            </div>
                            <a href="{{ route('rendezvous.create', ['medecin_id' => $doctor->id]) }}" class="activity-pts" style="text-decoration:none;">Choisir</a>
                        </div>
                    @empty
                        <div class="empty-state">
                            {{ $doctorSearch ? 'Aucun medecin ne correspond a cette recherche.' : 'Aucun medecin valide disponible pour le moment.' }}
                        </div>
                    @endforelse
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Top 3 medecins</span>
                        <span class="card-action">Classement points</span>
                    </div>
                    @forelse ($topMedecins as $index => $doctor)
                        <div class="activity-item">
                            <div class="activity-icon" style="background:{{ $index === 0 ? '#D9A441' : ($index === 1 ? '#8E9AAF' : '#B9784D') }};">
                                <span style="color:#fff;font-weight:800;">{{ $index + 1 }}</span>
                            </div>
                            <div style="flex:1;">
                                <div class="activity-name">Dr. {{ $doctor->user?->prenom }} {{ $doctor->user?->nom }}</div>
                                <div class="activity-meta">{{ $doctor->specialite ?: 'Consultation generale' }} · {{ $doctor->user?->ville ?: 'Ville non renseignee' }}</div>
                            </div>
                            <a href="{{ route('rendezvous.create', ['medecin_id' => $doctor->id]) }}" class="activity-pts" style="text-decoration:none;">{{ (int) ($doctor->points ?? 0) }} pts</a>
                        </div>
                    @empty
                        <div class="empty-state">Le classement sera disponible apres les premiers rendez-vous confirmes.</div>
                    @endforelse
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Activites disponibles</span>
                        <a href="{{ route('activites.index') }}" class="card-action">Toutes -></a>
                    </div>
                    @forelse ($availableActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="background:var(--gm);">
                                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                            </div>
                            <div>
                                <div class="activity-name">{{ $activity->titre }}</div>
                                <div class="activity-meta">{{ \Illuminate\Support\Carbon::parse($activity->date)->format('d/m/Y') }} · {{ $activity->association?->nom ?: 'Association' }}</div>
                            </div>
                            <span class="activity-pts">+{{ $activity->points }} pts</span>
                        </div>
                    @empty
                        <div class="empty-state">Aucune activite disponible pour le moment.</div>
                    @endforelse
                </div>
            </div>
        @elseif ($user->hasRole('admin') && isset($adminStats))
            <div class="page-header">
                <div>
                    <div class="page-title">Dashboard Admin</div>
                    <div class="page-subtitle">Gerez les utilisateurs, validez les professionnels et gardez une vue claire sur la plateforme.</div>
                </div>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon si-green"><svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></div>
                        <span class="stat-badge sb-up">Plateforme</span>
                    </div>
                    <div class="stat-val">{{ $adminStats['users_total'] }}</div>
                    <div class="stat-lbl">Utilisateurs totals</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon si-teal"><svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8V22h19.2v-2.8c0-3.2-6.4-4.8-9.6-4.8z"/></svg></div>
                        <span class="stat-badge sb-up">Patients</span>
                    </div>
                    <div class="stat-val">{{ $adminStats['patients_total'] }}</div>
                    <div class="stat-lbl">Comptes patient</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon si-gold"><svg viewBox="0 0 24 24"><path d="M12 2l7 3v6c0 5-3.4 9.7-7 11-3.6-1.3-7-6-7-11V5l7-3z"/></svg></div>
                        <span class="stat-badge sb-warn">Verification</span>
                    </div>
                    <div class="stat-val">{{ $adminStats['medecins_pending'] }}</div>
                    <div class="stat-lbl">Medecins en attente</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <div class="stat-icon si-sage"><svg viewBox="0 0 24 24"><path d="M19 19H5V8h14m0-2h-4V3H9v3H5c-1.1 0-2 .9-2 2v11a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2z"/></svg></div>
                        <span class="stat-badge sb-warn">Associations</span>
                    </div>
                    <div class="stat-val">{{ $adminStats['associations_pending'] }}</div>
                    <div class="stat-lbl">Associations en attente</div>
                </div>
            </div>

            <div class="dashboard-grid">
                <div>
                    <div class="card" style="margin-bottom:24px;">
                        <div class="card-header">
                            <span class="card-title">Utilisateurs recents</span>
                            <span class="card-action">{{ $adminUsers->count() }} affiches</span>
                        </div>
                        @forelse ($adminUsers as $managedUser)
                            <div class="rdv-item">
                                <div class="rdv-date">
                                    <div class="rdv-day">{{ strtoupper(substr($managedUser->prenom, 0, 1)) }}</div>
                                    <div class="rdv-month">{{ strtoupper(substr($managedUser->nom, 0, 1)) }}</div>
                                </div>
                                <div class="rdv-info">
                                    <div class="rdv-name">{{ $managedUser->prenom }} {{ $managedUser->nom }}</div>
                                    <div class="rdv-type">{{ $managedUser->email }} · Role : {{ ucfirst($managedUser->role) }}</div>
                                </div>
                                <div style="text-align:right;">
                                    <div class="rdv-time">{{ $managedUser->created_at?->format('d/m/Y') }}</div>
                                    <span class="badge {{ $managedUser->role === 'admin' ? 'badge-ok' : 'badge-pend' }}">{{ ucfirst($managedUser->role) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">Aucun utilisateur a afficher.</div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <div class="card" style="margin-bottom:24px;">
                        <div class="card-header">
                            <span class="card-title">Validation medecins</span>
                        </div>
                        @forelse ($pendingMedecins as $medecin)
                            <div class="activity-item" style="align-items:flex-start;">
                                <div class="activity-icon" style="background:var(--gm);">
                                    <svg viewBox="0 0 24 24"><path d="M19 8h-4V4h-2v4H9v2h4v4h2v-4h4zM5 19h14v2H5z"/></svg>
                                </div>
                                <div style="flex:1;">
                                    <div class="activity-name">Dr. {{ $medecin->user?->prenom }} {{ $medecin->user?->nom }}</div>
                                    <div class="activity-meta">{{ $medecin->specialite }} · {{ $medecin->user?->email }}</div>
                                    <form method="POST" action="{{ route('medecins.update', $medecin) }}" style="margin-top:10px;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-primary" style="padding:8px 16px;">Valider</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">Aucun medecin en attente.</div>
                        @endforelse
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <span class="card-title">Validation associations</span>
                        </div>
                        @forelse ($pendingAssociations as $associationItem)
                            <div class="activity-item" style="align-items:flex-start;">
                                <div class="activity-icon" style="background:#2D7A65;">
                                    <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zM8 11c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5C23 14.17 18.33 13 16 13z"/></svg>
                                </div>
                                <div style="flex:1;">
                                    <div class="activity-name">{{ $associationItem->nom }}</div>
                                    <div class="activity-meta">{{ $associationItem->user?->email }}</div>
                                    <form method="POST" action="{{ route('associations.update', $associationItem) }}" style="margin-top:10px;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-primary" style="padding:8px 16px;">Valider</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">Aucune association en attente.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @elseif ($user->hasRole('medecin') && isset($medecinStats))
            <div class="page-header">
                <div>
                    <div class="page-title">Dashboard Medecin</div>
                    <div class="page-subtitle">Suivez vos rendez-vous et validez rapidement les demandes de vos patients.</div>
                </div>
                <div class="header-right">
                    <a href="{{ route('rendezvous.index') }}" class="btn-primary">Voir tout</a>
                </div>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-badge sb-up">Prix</span>
                    </div>
                    <div class="stat-val">{{ $medecinStats['appointment_points_cost'] }}</div>
                    <div class="stat-lbl">Points demandes par rendez-vous</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-badge sb-up">Gagnes</span>
                    </div>
                    <div class="stat-val">{{ $medecinStats['earned_points'] }}</div>
                    <div class="stat-lbl">Points gagnes automatiquement</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-badge sb-up">Planning</span>
                    </div>
                    <div class="stat-val">{{ $medecinStats['total'] }}</div>
                    <div class="stat-lbl">Rendez-vous totaux</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                      <span class="stat-badge sb-warn">Aujourd'hui</span>
                    </div>
                    <div class="stat-val">{{ $medecinStats['today'] }}</div>
                    <div class="stat-lbl">Consultations du jour</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                        <span class="stat-badge sb-warn">Action requise</span>
                    </div>
                    <div class="stat-val">{{ $medecinStats['pending'] }}</div>
                    <div class="stat-lbl">Demandes en attente</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-top">
                       <span class="stat-badge sb-up">Valides</span>
                    </div>
                    <div class="stat-val">{{ $medecinStats['confirmed'] }}</div>
                    <div class="stat-lbl">Rendez-vous confirmes</div>
                </div>
            </div>

            <div class="card" style="margin-bottom:24px;">
                <div class="card-header">
                    <span class="card-title">Points du rendez-vous</span>
                    <span class="card-action">Modifiable</span>
                </div>
                <form method="POST" action="{{ route('medecins.appointment-cost.update') }}" style="display:grid;grid-template-columns:1fr auto;gap:14px;align-items:end;">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="label" for="appointment_points_cost">Points demandes au patient</label>
                        <input class="input" id="appointment_points_cost" name="appointment_points_cost" type="number" min="1" value="{{ old('appointment_points_cost', $medecinStats['appointment_points_cost']) }}">
                        <p style="margin-top:8px;color:var(--tl);font-size:.82rem;">Cette valeur s'affiche dans le formulaire de prise de rendez-vous et sera depensee par le patient apres votre confirmation.</p>
                    </div>
                    <button type="submit" class="btn-primary">Modifier</button>
                </form>
                <div style="margin-top:16px;padding:14px 16px;border-radius:14px;background:#F4F7F5;color:var(--gm);font-size:.88rem;">
                    Points gagnes par vos rendez-vous confirmes : <strong>{{ $medecinStats['earned_points'] }} pts</strong>. Cette valeur est calculee automatiquement et ne se modifie pas manuellement.
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="card-title">Mes rendez-vous</span>
                    <a href="{{ route('rendezvous.index') }}" class="card-action">Liste complete -></a>
                </div>

                @forelse ($medecinAppointments as $rdv)
                    @php
                        $rdvDate = \Illuminate\Support\Carbon::parse($rdv->date);
                        $statusClass = match($rdv->statut) {
                            'confirme', 'confirmé' => 'badge-ok',
                            'annule', 'annulé', 'refuse' => 'badge-cancel',
                            default => 'badge-pend',
                        };
                    @endphp
                    <div class="rdv-item" style="align-items:flex-start;">
                        <div class="rdv-date">
                            <div class="rdv-day">{{ $rdvDate->format('d') }}</div>
                            <div class="rdv-month">{{ $rdvDate->format('M') }}</div>
                        </div>
                        <div class="rdv-info">
                            <div class="rdv-name">{{ $rdv->patient?->user?->prenom }} {{ $rdv->patient?->user?->nom }}</div>
                            <div class="rdv-type">{{ substr($rdv->heure, 0, 5) }} · Statut : <span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $rdv->statut)) }}</span></div>
                            @if ($rdv->statut === 'en_attente')
                                <div style="display:flex; gap:10px; margin-top:12px; flex-wrap:wrap;">
                                    <form method="POST" action="{{ route('rendezvous.status', $rdv) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="statut" value="confirme">
                                        <button type="submit" class="btn-primary" style="padding:8px 16px;">Accepter</button>
                                    </form>
                                    <form method="POST" action="{{ route('rendezvous.status', $rdv) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="statut" value="annule">
                                        <button type="submit" class="btn-outline" style="padding:8px 16px; border-color:#E05C5C; color:#E05C5C;">Refuser</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">Aucun rendez-vous associe a votre compte pour le moment.</div>
                @endforelse
            </div>
        @elseif ($user->hasRole('association') && isset($association))
            <div class="page-header">
                <div>
                    <div class="page-title">Dashboard Association</div>
                    <div class="page-subtitle">Pilotez vos activites et votre impact depuis un seul espace.</div>
                </div>
                <div class="header-right">
                    <a href="#create-activity" class="btn-primary">+ Nouvelle activite</a>
                </div>
            </div>

            <div class="assoc-hero">
                <div style="font-size:.82rem;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.7);">Espace Association</div>
                <h1 style="margin-top:10px;font-family:'Playfair Display',serif;font-size:2.3rem;">{{ $association->nom }}</h1>
                <p style="margin-top:12px;max-width:720px;line-height:1.8;color:rgba(255,255,255,.82);">
                    {{ $association->description ?: 'Ajoutez vos activites pour mobiliser votre communaute et soutenir les patients grace au systeme de points.' }}
                </p>
                <div class="assoc-stats">
                    <div class="assoc-stat"><p>Activites publiees</p><p>{{ $stats['total'] ?? 0 }}</p></div>
                    <div class="assoc-stat"><p>A venir</p><p>{{ $stats['avenir'] ?? 0 }}</p></div>
                    <div class="assoc-stat"><p>Points distribues</p><p>{{ $stats['points'] ?? 0 }}</p></div>
                </div>
            </div>

            <div class="assoc-grid">
                <section class="card" id="create-activity">
                    <div class="card-header">
                        <span class="card-title">Creer une activite</span>
                    </div>
                    <form method="POST" action="{{ route('activites.store') }}" class="stack">
                        @csrf
                        <div>
                            <label class="label" for="titre">Titre</label>
                            <input class="input" id="titre" name="titre" type="text" value="{{ old('titre') }}" placeholder="Atelier de soutien collectif">
                        </div>
                        <div>
                            <label class="label" for="description">Description</label>
                            <textarea class="textarea" id="description" name="description" placeholder="Expliquez le deroulement de l'activite.">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-grid">
                            <div>
                                <label class="label" for="date">Date</label>
                                <input class="input" id="date" name="date" type="date" value="{{ old('date') }}">
                            </div>
                            <div>
                                <label class="label" for="points">Points</label>
                                <input class="input" id="points" name="points" type="number" min="1" value="{{ old('points') }}" placeholder="50">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn-primary">Publier l'activite</button>
                        </div>
                    </form>
                </section>

                <aside class="card">
                    <div class="card-header">
                        <span class="card-title">Mes activites</span>
                    </div>
                    <div class="stack">
                        @forelse ($activites as $activite)
                            <article class="activity-card">
                                <div class="activity-card-header">
                                    <div>
                                        <div style="font-weight:700;color:var(--td);">{{ $activite->titre }}</div>
                                        <div style="margin-top:4px;font-size:.78rem;color:var(--tl);">{{ \Illuminate\Support\Carbon::parse($activite->date)->format('d/m/Y') }}</div>
                                    </div>
                                    <span class="pill pill-green">{{ $activite->points }} pts</span>
                                </div>
                                <p style="margin-top:12px;font-size:.86rem;line-height:1.7;color:var(--tm);">{{ $activite->description }}</p>
                                <form method="POST" action="{{ route('activites.destroy', $activite) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Supprimer</button>
                                </form>
                            </article>
                        @empty
                            <div class="empty-state">Aucune activite pour le moment.</div>
                        @endforelse
                    </div>
                </aside>
            </div>
        @else
            <div class="page-header">
                <div>
                    <div class="page-title">Bienvenue {{ $user->prenom }} {{ $user->nom }}</div>
                    <div class="page-subtitle">Votre tableau de bord sera enrichi selon votre role.</div>
                </div>
            </div>
            <div class="card">
                <p style="line-height:1.8;color:var(--tm);">Aucune vue specifique n'est encore configuree pour ce profil.</p>
            </div>
        @endif
    </main>
</div>
</body>
</html>
