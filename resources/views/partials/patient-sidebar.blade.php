@php
    $sidebarUser = $user ?? auth()->user();
    $sidebarPatient = $patient ?? $sidebarUser?->patient;
    $sidebarInitials = $initials ?? strtoupper(substr($sidebarUser->prenom ?? '', 0, 1) . substr($sidebarUser->nom ?? '', 0, 1));
    $sidebarPoints = $patientPoints
        ?? ($patientStats['points'] ?? ($sidebarPatient->points ?? 0));
@endphp

<aside class="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-logo">
        <span class="sidebar-logo-text">Second<span>Chance</span></span>
    </a>

    <span class="sidebar-section">Principal</span>
    <a href="{{ route('dashboard') }}" class="sidebar-link {{ ($active ?? '') === 'dashboard' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Tableau de bord
    </a>
    <a href="{{ route('rendezvous.index') }}" class="sidebar-link {{ ($active ?? '') === 'rendezvous' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-7h-5v5h5v-5z"/></svg>Rendez-vous
    </a>
    <a href="{{ route('patient.dossier') }}" class="sidebar-link {{ ($active ?? '') === 'dossier' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>Mon dossier
    </a>

    <span class="sidebar-section">Communaute</span>
    <a href="{{ route('activites.index') }}" class="sidebar-link {{ ($active ?? '') === 'activites' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>Activites & Ateliers
    </a>
    <a href="{{ route('messages.index') }}" class="sidebar-link {{ ($active ?? '') === 'messages' ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm0 14H5.17L4 17.17V4h16v12z"/></svg>Messagerie
    </a>

    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ $sidebarInitials ?: 'SC' }}</div>
            <div>
                <div class="sidebar-user-name">{{ $sidebarUser->prenom }} {{ $sidebarUser->nom }}</div>
                <div class="sidebar-user-role">Patient · {{ $sidebarPoints }} pts</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Se deconnecter</button>
        </form>
    </div>
</aside>
