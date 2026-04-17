<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --gd:#051F20; --gm:#235347; --gl:#8EB69B; --gp:#DAF1DE; --wh:#fff; --cr:#F4F7F5; --td:#0D1F1E; --tl:#7A9E93; --ok:#4CAF7D; --warn:#E8A838; --danger:#E05C5C; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'DM Sans',sans-serif; background:var(--cr); color:var(--td); }
        .page { max-width:1150px; margin:0 auto; padding:32px 18px 48px; }
        .topbar { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:28px; }
        .title { font-family:'Playfair Display',serif; font-size:2rem; }
        .subtitle { margin-top:6px; color:var(--tl); font-size:.92rem; }
        .btn { display:inline-flex; align-items:center; justify-content:center; padding:11px 18px; border-radius:999px; text-decoration:none; font-weight:700; font-size:.86rem; }
        .btn-primary { background:var(--gm); color:var(--wh); }
        .btn-outline { border:1.5px solid var(--gm); color:var(--gm); background:transparent; }
        .alert { margin-bottom:18px; padding:14px 16px; border-radius:14px; font-size:.9rem; }
        .alert-success { background:#edf9f1; color:#1e6242; border:1px solid #cdebd5; }
        .grid { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; margin-bottom:22px; }
        .stat { background:var(--wh); border-radius:18px; padding:20px; box-shadow:0 4px 18px rgba(5,31,32,.05); }
        .stat p:first-child { font-size:.8rem; color:var(--tl); }
        .stat p:last-child { margin-top:8px; font-size:2rem; font-family:'Playfair Display',serif; }
        .card { background:var(--wh); border-radius:24px; padding:26px; box-shadow:0 4px 18px rgba(5,31,32,.05); }
        .list { display:grid; gap:16px; }
        .item { border:1px solid #e8efeb; border-radius:18px; padding:18px; display:grid; grid-template-columns:1fr auto; gap:14px; align-items:center; }
        .name { font-weight:700; font-size:1rem; }
        .meta { margin-top:6px; color:var(--tl); font-size:.86rem; line-height:1.7; }
        .right { text-align:right; }
        .date { color:var(--gm); font-weight:700; font-size:.95rem; }
        .badge { display:inline-flex; padding:5px 10px; border-radius:999px; font-size:.72rem; font-weight:700; margin-top:8px; }
        .badge-ok { color:var(--ok); background:rgba(76,175,125,.12); }
        .badge-pending { color:var(--warn); background:rgba(232,168,56,.12); }
        .badge-cancel { color:var(--danger); background:rgba(224,92,92,.12); }
        .actions { display:flex; justify-content:flex-end; gap:10px; margin-top:14px; }
        .btn-sm { padding:9px 14px; border-radius:999px; font-size:.78rem; font-weight:700; background:transparent; cursor:pointer; }
        .btn-edit { border:1px solid #cfe1d7; color:var(--gm); text-decoration:none; }
        .btn-delete { border:1px solid #f1c9c9; color:#c64f4f; background:#fff; }
        .empty { text-align:center; padding:28px; color:var(--tl); }
        @media (max-width: 860px) {
            .topbar { flex-direction:column; align-items:flex-start; }
            .grid { grid-template-columns:1fr; }
            .item { grid-template-columns:1fr; }
            .right { text-align:left; }
            .actions { justify-content:flex-start; }
        }
    </style>
</head>
<body>
@php
    $user = auth()->user();
    $total = $rendezVous->count();
    $upcoming = $rendezVous->filter(fn ($rdv) => $rdv->date >= now()->toDateString())->count();
    $confirmed = $rendezVous->filter(fn ($rdv) => in_array($rdv->statut, ['confirme', 'confirmé']))->count();
@endphp
<div class="page">
    <div class="topbar">
        <div>
            <h1 class="title">Mes rendez-vous</h1>
            <p class="subtitle">Suivez vos consultations, modifiez-les si besoin et gardez une vue claire sur votre parcours.</p>
        </div>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            <a href="{{ route('dashboard') }}" class="btn btn-outline">Retour dashboard</a>
            @if ($user->hasRole('patient'))
                <a href="{{ route('rendezvous.create') }}" class="btn btn-primary">+ Nouveau rendez-vous</a>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="grid">
        <div class="stat"><p>Total</p><p>{{ $total }}</p></div>
        <div class="stat"><p>A venir</p><p>{{ $upcoming }}</p></div>
        <div class="stat"><p>Confirmes</p><p>{{ $confirmed }}</p></div>
    </div>

    <div class="card">
        <div class="list">
            @forelse ($rendezVous as $rdv)
                @php
                    $statusClass = match($rdv->statut) {
                        'confirme', 'confirmé' => 'badge-ok',
                        'annule', 'annulé', 'refuse' => 'badge-cancel',
                        default => 'badge-pending',
                    };
                @endphp
                <article class="item">
                    <div>
                        <div class="name">
                            @if ($user->hasRole('patient'))
                                Dr. {{ $rdv->medecin?->user?->prenom }} {{ $rdv->medecin?->user?->nom }}
                            @elseif ($user->hasRole('medecin'))
                                {{ $rdv->patient?->user?->prenom }} {{ $rdv->patient?->user?->nom }}
                            @else
                                {{ $rdv->patient?->user?->prenom }} {{ $rdv->patient?->user?->nom }} / Dr. {{ $rdv->medecin?->user?->prenom }} {{ $rdv->medecin?->user?->nom }}
                            @endif
                        </div>
                        <div class="meta">
                            Specialite : {{ $rdv->medecin?->specialite ?: 'Consultation generale' }}<br>
                            Date : {{ \Illuminate\Support\Carbon::parse($rdv->date)->format('d/m/Y') }} a {{ substr($rdv->heure, 0, 5) }}
                        </div>
                    </div>
                    <div class="right">
                        <div class="date">{{ ucfirst(str_replace('_', ' ', $rdv->statut)) }}</div>
                        <span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $rdv->statut)) }}</span>
                        <div class="actions">
                            <a href="{{ route('rendezvous.edit', $rdv) }}" class="btn-sm btn-edit">Modifier</a>
                            <form method="POST" action="{{ route('rendezvous.destroy', $rdv) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty">Aucun rendez-vous pour le moment.</div>
            @endforelse
        </div>
    </div>
</div>
</body>
</html>
