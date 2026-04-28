<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Activites</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --gd:#051F20; --gm:#235347; --gl:#8EB69B; --gp:#DAF1DE; --wh:#fff; --cr:#F4F7F5; --td:#0D1F1E; --tm:#3A5A52; --tl:#7A9E93; --line:#E3ECE7; --warn:#E8A838; --danger:#D95D5D; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'DM Sans',sans-serif; background:linear-gradient(180deg,#f7fbf8 0%,#edf4f0 100%); color:var(--td); min-height:100vh; }
        a { color:inherit; text-decoration:none; }
        .page { max-width:1180px; margin:0 auto; padding:32px 18px 48px; }
        .hero { display:flex; justify-content:space-between; align-items:flex-end; gap:20px; margin-bottom:24px; }
        .hero h1 { font-family:'Playfair Display',serif; font-size:2.4rem; }
        .hero p { margin-top:10px; max-width:720px; color:var(--tl); line-height:1.7; }
        .btn { display:inline-flex; align-items:center; justify-content:center; padding:11px 18px; border-radius:999px; font-size:.86rem; font-weight:700; }
        .btn-outline { border:1.5px solid var(--gm); color:var(--gm); background:transparent; }
        .stats { display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:24px; }
        .stat { background:#fff; border-radius:24px; padding:18px; box-shadow:0 12px 30px rgba(5,31,32,.06); }
        .stat-label { color:var(--tl); font-size:.76rem; text-transform:uppercase; letter-spacing:.06em; }
        .stat-value { margin-top:8px; font-family:'Playfair Display',serif; font-size:2rem; }
        .alert-success, .alert-error { margin-bottom:18px; padding:14px 16px; border-radius:18px; font-size:.9rem; }
        .alert-success { background:#edf9f1; color:#1e6242; border:1px solid #cdebd5; }
        .alert-error { background:#fff1f1; color:#9a3535; border:1px solid #ffd0d0; }
        .alert-error ul { padding-left:18px; }
        .section { margin-bottom:24px; }
        .section-title { margin-bottom:14px; font-size:1.05rem; font-weight:700; }
        .grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:18px; }
        .card { background:#fff; border-radius:28px; padding:22px; box-shadow:0 14px 34px rgba(5,31,32,.07); }
        .card-top { display:flex; justify-content:space-between; gap:16px; align-items:flex-start; }
        .card-title { font-size:1.08rem; font-weight:700; }
        .card-meta { margin-top:8px; color:var(--tl); font-size:.84rem; line-height:1.6; }
        .card-body { margin-top:16px; color:var(--tm); line-height:1.75; font-size:.92rem; }
        .pills { display:flex; flex-wrap:wrap; gap:8px; margin-top:16px; }
        .pill { display:inline-flex; align-items:center; padding:7px 12px; border-radius:999px; font-size:.74rem; font-weight:700; }
        .pill-green { background:#edf6ef; color:var(--gm); }
        .pill-warn { background:#fff5dd; color:#8c6611; }
        .pill-red { background:#fff0f0; color:#9a3535; }
        .actions { margin-top:18px; display:flex; gap:10px; flex-wrap:wrap; }
        .btn-primary { background:var(--gm); color:#fff; border:none; cursor:pointer; }
        .btn-secondary { background:#eef5f1; color:var(--gm); border:none; cursor:pointer; }
        .stack { display:grid; gap:12px; }
        .input, .textarea { width:100%; border:1px solid #d6e2db; border-radius:16px; padding:13px 14px; font:inherit; background:#fff; }
        .textarea { min-height:120px; resize:vertical; }
        .participant-list { margin-top:18px; display:grid; gap:12px; }
        .participant { padding:14px; border-radius:18px; background:#f7fbf8; border:1px solid var(--line); }
        .participant-top { display:flex; justify-content:space-between; gap:12px; align-items:flex-start; }
        .participant-name { font-weight:700; }
        .participant-meta { margin-top:4px; color:var(--tl); font-size:.82rem; }
        .participant-actions { margin-top:12px; display:flex; gap:10px; flex-wrap:wrap; }
        .empty { padding:22px; border-radius:22px; background:#fff; color:var(--tl); text-align:center; }
        @media (max-width: 900px) { .grid, .stats { grid-template-columns:1fr; } }
        @media (max-width: 720px) { .hero { flex-direction:column; align-items:flex-start; } }
    </style>
</head>
<body>
@php
    $user = $user ?? auth()->user();
    $activites = $activites ?? collect();
    $participations = $participations ?? collect();
@endphp
<div class="page">
    <section class="hero">
        <div>
            <h1>Activites et ateliers</h1>
            <p>
                @if ($user?->hasRole('association'))
                    Publiez vos activites, gerez les demandes de participation et validez les membres avant la date de l evenement.
                @else
                    Retrouvez toutes les activites disponibles, postulez en un clic et suivez la reponse de l association.
                @endif
            </p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline">Retour dashboard</a>
    </section>

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

    <section class="stats">
        <div class="stat">
            <div class="stat-label">Total</div>
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">A venir</div>
            <div class="stat-value">{{ $stats['avenir'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">Points proposes</div>
            <div class="stat-value">{{ $stats['points'] ?? 0 }}</div>
        </div>
    </section>

    @if ($user?->hasRole('association'))
        <section class="section">
            <div class="section-title">Creer une activite</div>
            <div class="card">
                <form method="POST" action="{{ route('activites.store') }}" class="stack">
                    @csrf
                    <input class="input" type="text" name="titre" value="{{ old('titre') }}" placeholder="Titre de l activite">
                    <textarea class="textarea" name="description" placeholder="Description de l activite">{{ old('description') }}</textarea>
                    <div class="grid">
                        <input class="input" type="date" name="date" value="{{ old('date') }}" min="{{ now()->toDateString() }}">
                        <input class="input" type="number" name="points" value="{{ old('points') }}" min="1" placeholder="Points a attribuer">
                    </div>
                    <div class="actions">
                        <button type="submit" class="btn btn-primary">Publier l activite</button>
                    </div>
                </form>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="section-title">
            @if ($user?->hasRole('association'))
                Mes activites et demandes
            @else
                Toutes les activites
            @endif
        </div>

        @if ($activites->isNotEmpty())
            <div class="grid">
                @foreach ($activites as $activite)
                    @php
                        $participation = $user?->hasRole('patient') ? $participations->get($activite->id) : null;
                        $participationLabel = match($participation?->statut) {
                            'accepte' => 'Accepte',
                            'refuse' => 'Refuse',
                            'en_attente' => 'En attente',
                            default => null,
                        };
                        $participationClass = match($participation?->statut) {
                            'accepte' => 'pill-green',
                            'refuse' => 'pill-red',
                            'en_attente' => 'pill-warn',
                            default => 'pill-green',
                        };
                    @endphp
                    <article class="card">
                        <div class="card-top">
                            <div>
                                <div class="card-title">{{ $activite->titre }}</div>
                                <div class="card-meta">
                                    {{ \Illuminate\Support\Carbon::parse($activite->date)->format('d/m/Y') }}
                                    · {{ $activite->association?->nom ?: ($activite->association?->user?->prenom . ' ' . $activite->association?->user?->nom) }}
                                </div>
                            </div>
                            <span class="pill pill-green">{{ $activite->points }} pts</span>
                        </div>

                        <div class="card-body">{{ $activite->description }}</div>

                        <div class="pills">
                            @if ($user?->hasRole('patient') && $participationLabel)
                                <span class="pill {{ $participationClass }}">Votre demande : {{ $participationLabel }}</span>
                            @endif
                            @if ($user?->hasRole('association'))
                                <span class="pill pill-warn">{{ $activite->participations->count() }} demande(s)</span>
                            @endif
                        </div>

                        @if ($user?->hasRole('patient'))
                            <div class="actions">
                                @if (! $participation)
                                    <form method="POST" action="{{ route('participer', $activite->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Postuler a cette activite</button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-secondary" disabled>Demande deja envoyee</button>
                                @endif
                            </div>
                        @endif

                        @if ($user?->hasRole('association'))
                            <div class="participant-list">
                                @forelse ($activite->participations as $participationItem)
                                    <div class="participant">
                                        <div class="participant-top">
                                            <div>
                                                <div class="participant-name">{{ $participationItem->patient?->user?->prenom }} {{ $participationItem->patient?->user?->nom }}</div>
                                                <div class="participant-meta">
                                                    {{ $participationItem->patient?->user?->email }}
                                                    · Demande du {{ $participationItem->created_at?->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                            <span class="pill {{ match($participationItem->statut) { 'accepte' => 'pill-green', 'refuse' => 'pill-red', default => 'pill-warn' } }}">
                                                {{ ucfirst(str_replace('_', ' ', $participationItem->statut)) }}
                                            </span>
                                        </div>

                                        @if ($participationItem->statut === 'en_attente')
                                            <div class="participant-actions">
                                                <form method="POST" action="{{ route('participations.update', $participationItem->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="statut" value="accepte">
                                                    <button type="submit" class="btn btn-primary">Accepter</button>
                                                </form>
                                                <form method="POST" action="{{ route('participations.update', $participationItem->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="statut" value="refuse">
                                                    <button type="submit" class="btn btn-secondary">Refuser</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="empty">Aucune demande pour cette activite.</div>
                                @endforelse
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty">Aucune activite disponible pour le moment.</div>
        @endif
    </section>
</div>
</body>
</html>
