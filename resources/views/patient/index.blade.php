<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Second Chance - Mon Dossier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/patient.css'])
</head>
<body>
@php
    $initials = strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1));
    $patientCode = 'SC-' . str_pad((string) $patient->id, 5, '0', STR_PAD_LEFT);
    $level = $patient->points >= 2000 ? 'Or' : ($patient->points >= 1000 ? 'Argent' : 'Bronze');
    $latestMedecin = $rendezVous->first()?->medecin?->user;
@endphp
@include('partials.patient-sidebar', ['active' => 'dossier'])

<main class="main">
    <div class="page-header">
        <div><div class="page-title">Mon Dossier Medical</div><div class="page-subtitle">Confidentiel · Chiffre · Securise</div></div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;"><a href="{{ route('dashboard') }}" class="btn-outline">Retour dashboard</a><a href="{{ route('profile.edit') }}" class="btn-primary">Modifier mon profil</a></div>
    </div>

    <div class="profile-card">
        <div class="profile-avatar">{{ $initials ?: 'SC' }}</div>
        <div class="profile-info">
            <div class="profile-name">{{ $user->prenom }} {{ $user->nom }}</div>
            <div class="profile-meta">
                <span class="pmeta"> {{ $user->ville ?: 'Ville non renseignee' }}</span>
            </div>
            <div class="profile-badges">
                <span class="pbadge pbadge-pts">{{ $patient->points }} points</span>
                <span class="pbadge" style="background:rgba(232,168,56,.15);color:var(--warn);">Niveau {{ $level }}</span>
            </div>
            <div class="profile-completion">
                <div class="pcomp-label"><span>Dossier complete a {{ $completion }}%</span><span>{{ $completion }}%</span></div>
                <div class="pcomp-bar"><div class="pcomp-fill" style="width:{{ $completion }}%"></div></div>
            </div>
        </div>
    </div>

    <div class="tabs">
        <button class="tab active" onclick="switchTab('info',this)">Informations</button>
        <button class="tab" onclick="switchTab('history',this)">Historique</button>
        <button class="tab" onclick="switchTab('docs',this)">Documents</button>
        <button class="tab" onclick="switchTab('health',this)">Sante</button>
    </div>

    <div class="tab-content active" id="tab-info">
        <div class="grid-2" style="margin-bottom:20px;">
            <div class="card">
                <div class="card-title">Informations personnelles <a href="{{ route('profile.edit') }}" class="card-edit">Modifier</a></div>
                <div class="info-row"><span class="info-key">Nom complet</span><span class="info-val">{{ $user->prenom }} {{ $user->nom }}</span></div>
                <div class="info-row"><span class="info-key">Date de naissance</span><span class="info-val">{{ $user->date_naissance ? \Illuminate\Support\Carbon::parse($user->date_naissance)->translatedFormat('d F Y') : 'Non renseignee' }}</span></div>
                <div class="info-row"><span class="info-key">Telephone</span><span class="info-val">{{ $user->telephone ?: 'Non renseigne' }}</span></div>
                <div class="info-row"><span class="info-key">Email</span><span class="info-val">{{ $user->email }}</span></div>
                <div class="info-row"><span class="info-key">Ville</span><span class="info-val">{{ $user->ville ?: 'Non renseignee' }}</span></div>
                <div class="info-row"><span class="info-key">Genre</span><span class="info-val">{{ $user->genre ?: 'Non renseigne' }}</span></div>
            </div>
            <div class="card">
                <div class="card-title">Situation medicale <a href="{{ route('profile.edit') }}" class="card-edit">Modifier</a></div>
                <div class="info-row"><span class="info-key">Type d'addiction</span><span class="info-val">{{ $patient->type_addiction ?: 'Non renseigne' }}</span></div>
                <div class="info-row"><span class="info-key">Medecin referent</span><span class="info-val">{{ $latestMedecin ? 'Dr. '.$latestMedecin->prenom.' '.$latestMedecin->nom : 'Aucun pour le moment' }}</span></div>
                <div class="info-row"><span class="info-key">Statut du suivi</span><span class="info-val"><span class="badge badge-ok">{{ $rendezVous->count() > 0 ? 'Actif' : 'Initial' }}</span></span></div>
                <div class="info-row"><span class="info-key">Date d'inscription</span><span class="info-val">{{ $user->created_at?->format('d/m/Y') }}</span></div>
                <div class="info-row"><span class="info-key">Rendez-vous</span><span class="info-val">{{ $rendezVous->count() }}</span></div>
                <div class="info-row"><span class="info-key">Points actuels</span><span class="info-val">{{ $patient->points }}</span></div>
            </div>
        </div>
        <div class="card">
            <div class="card-title">Mes medecins traitants</div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;">
                @forelse ($medecins as $medecin)
                    <div style="background:var(--gp);border-radius:14px;padding:16px;display:flex;align-items:center;gap:12px;">
                        <div style="width:42px;height:42px;background:var(--gm);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--wh);flex-shrink:0;">{{ strtoupper(substr($medecin->user?->prenom ?? 'M',0,1).substr($medecin->user?->nom ?? 'D',0,1)) }}</div>
                        <div><div style="font-weight:600;font-size:.88rem;color:var(--td);">Dr. {{ $medecin->user?->prenom }} {{ $medecin->user?->nom }}</div><div style="font-size:.75rem;color:var(--tl);">{{ $medecin->specialite ?: 'Medecin' }}</div></div>
                    </div>
                @empty
                    <div class="empty">Aucun medecin associe pour le moment.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="tab-content" id="tab-history">
        <div class="grid-2">
            <div class="card">
                <div class="card-title">Historique des consultations</div>
                <div class="timeline">
                    @forelse ($rendezVous->take(6) as $rdv)
                        <div class="tl-item"><div class="tl-dot rdv"><svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-7-7h-5v5h5v-5z"/></svg></div><div class="tl-body"><div class="tl-date">{{ \Illuminate\Support\Carbon::parse($rdv->date)->format('d/m/Y') }}</div><div class="tl-title">Consultation - Dr. {{ $rdv->medecin?->user?->prenom }} {{ $rdv->medecin?->user?->nom }}</div><div class="tl-desc">{{ $rdv->medecin?->specialite ?: 'Consultation' }} · {{ substr($rdv->heure,0,5) }} · Statut : {{ ucfirst(str_replace('_',' ',$rdv->statut)) }}</div></div></div>
                    @empty
                        <div class="empty">Aucune consultation dans votre historique.</div>
                    @endforelse
                </div>
            </div>
            <div class="card">
                <div class="card-title">Historique points et activites</div>
                @forelse ($transactions as $transaction)
                    <div style="background:{{ $loop->first ? 'var(--gp)' : 'var(--cr)' }};border-radius:14px;padding:18px;margin-bottom:14px;">
                        <div style="font-size:.73rem;color:var(--tl);margin-bottom:6px;">{{ $transaction->created_at?->format('d/m/Y H:i') }}</div>
                        <p style="font-size:.87rem;color:var(--td);line-height:1.6;">{{ $transaction->description }} · <strong>{{ $transaction->type === 'gain' ? '+' : '-' }}{{ abs($transaction->montant) }} pts</strong></p>
                    </div>
                @empty
                    <div class="empty">Aucune transaction disponible.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="tab-content" id="tab-docs">
        <div class="card">
            <div class="card-title">Mes documents <span class="badge badge-warn">Bientot</span></div>
            @forelse ($participations as $participation)
                <div class="doc-item"><div><div class="doc-name">{{ $participation->activite?->titre ?: 'Activite' }}</div><div class="doc-meta">{{ $participation->activite?->association?->nom ?: 'Association' }} · {{ $participation->created_at?->format('d/m/Y') }}</div></div><button class="doc-dl" type="button">Indisponible</button></div>
            @empty
                <div class="empty">Aucun document medical ou attestation n'a encore ete ajoute.</div>
            @endforelse
        </div>
    </div>

    <div class="tab-content" id="tab-health">
        <div class="grid-3" style="margin-bottom:20px;">
            <div class="metric-card"><div class="metric-val">{{ $globalProgress }}%</div><div class="metric-label">Progres global</div><div class="metric-bar"><div class="metric-fill" style="width:{{ $globalProgress }}%"></div></div></div>
            <div class="metric-card"><div class="metric-val">{{ $regularite }}%</div><div class="metric-label">Regularite RDV</div><div class="metric-bar"><div class="metric-fill" style="width:{{ $regularite }}%"></div></div></div>
            <div class="metric-card"><div class="metric-val">{{ $participations->count() }}/5</div><div class="metric-label">Ateliers suivis</div><div class="metric-bar"><div class="metric-fill" style="width:{{ $participationRate }}%"></div></div></div>
        </div>
        <div class="card">
            <div class="card-title">Suivi de bien-etre</div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-top:8px;">
                <div style="text-align:center;padding:16px;background:var(--gp);border-radius:14px;"><div style="font-size:2rem;margin-bottom:6px;"></div><div style="font-size:.8rem;font-weight:600;color:var(--gm);">Cette semaine</div><div style="font-size:.72rem;color:var(--tl);">{{ $globalProgress >= 70 ? 'Bien' : ($globalProgress >= 40 ? 'Moyen' : 'Fragile') }}</div></div>
                <div style="text-align:center;padding:16px;background:var(--cr);border-radius:14px;"><div style="font-size:2rem;margin-bottom:6px;"></div><div style="font-size:.8rem;font-weight:600;color:var(--td);">Rendez-vous</div><div style="font-size:.72rem;color:var(--tl);">{{ $rendezVous->count() }} total</div></div>
                <div style="text-align:center;padding:16px;background:var(--cr);border-radius:14px;"><div style="font-size:2rem;margin-bottom:6px;"></div><div style="font-size:.8rem;font-weight:600;color:var(--td);">Points</div><div style="font-size:.72rem;color:var(--tl);">{{ $patient->points }} pts</div></div>
                <div style="text-align:center;padding:16px;background:var(--cr);border-radius:14px;"><div style="font-size:2rem;margin-bottom:6px;"></div><div style="font-size:.8rem;font-weight:600;color:var(--td);">Participations</div><div style="font-size:.72rem;color:var(--tl);">{{ $participations->count() }} recentes</div></div>
            </div>
        </div>
    </div>
</main>

<script>
function switchTab(id, btn) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('tab-' + id).classList.add('active');
}
</script>
</body>
</html>
