<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau rendez-vous</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --gd:#051F20; --gm:#235347; --gl:#8EB69B; --gp:#DAF1DE; --wh:#fff; --cr:#F4F7F5; --td:#0D1F1E; --tl:#7A9E93; --danger:#E05C5C; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'DM Sans',sans-serif; background:linear-gradient(180deg,#eef4f1 0%,#f4f7f5 100%); color:var(--td); }
        .wrap { max-width:820px; margin:0 auto; padding:34px 18px 48px; }
        .hero { background:linear-gradient(135deg,#143C3C 0%, #235347 60%, #8EB69B 100%); border-radius:30px; padding:30px; color:#fff; margin-bottom:24px; }
        .hero h1 { font-family:'Playfair Display',serif; font-size:2.2rem; }
        .hero p { margin-top:10px; color:rgba(255,255,255,.82); line-height:1.8; }
        .card { background:#fff; border-radius:24px; padding:26px; box-shadow:0 10px 30px rgba(5,31,32,.06); }
        .grid { display:grid; gap:18px; grid-template-columns:1fr 1fr; }
        .field { margin-bottom:18px; }
        label { display:block; margin-bottom:8px; font-weight:700; font-size:.88rem; }
        select, input { width:100%; border:1px solid #d6e2db; border-radius:15px; padding:14px 16px; font:inherit; background:#fff; }
        .actions { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-top:8px; }
        .btn { display:inline-flex; align-items:center; justify-content:center; padding:11px 18px; border-radius:999px; text-decoration:none; font-weight:700; font-size:.86rem; }
        .btn-primary { background:var(--gm); color:#fff; border:none; cursor:pointer; }
        .btn-outline { border:1.5px solid var(--gm); color:var(--gm); background:transparent; }
        .errors { margin-bottom:18px; padding:14px 16px; border-radius:14px; background:#fff1f1; border:1px solid #ffd0d0; color:#9a3535; font-size:.9rem; }
        .errors ul { padding-left:18px; }
        .doctor-card { margin-top:18px; background:var(--gp); border-radius:18px; padding:16px; color:var(--gm); font-size:.86rem; line-height:1.8; }
        @media (max-width: 720px) { .grid { grid-template-columns:1fr; } .actions { flex-direction:column; align-items:stretch; } }
    </style>
</head>
<body>
@php
    $appointmentCost = $appointmentCost ?? \App\Models\RendezVous::DEFAULT_POINTS_COST;
    $patientPoints = auth()->user()?->patient?->points;
    $doctorCosts = ($doctorCosts ?? collect())->toArray();
@endphp
<div class="wrap">
    <div class="hero">
        <h1>Prendre un rendez-vous</h1>
        <p>Choisissez un medecin valide, une date et un horaire pour envoyer votre demande depuis votre espace patient.</p>
    </div>

    <div class="card">
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('rendezvous.store') }}">
            @csrf
            <div class="field">
                <label for="medecin_id">Medecin</label>
                <select id="medecin_id" name="medecin_id">
                    <option value="">Choisir un medecin</option>
                    @foreach ($medecins as $medecin)
                        <option value="{{ $medecin->id }}" data-points-cost="{{ $doctorCosts[$medecin->id] ?? \App\Models\RendezVous::DEFAULT_POINTS_COST }}" @selected(old('medecin_id', request('medecin_id')) == $medecin->id)>
                            Dr. {{ $medecin->user?->prenom }} {{ $medecin->user?->nom }} - {{ $medecin->specialite }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid">
                <div class="field">
                    <label for="date">Date</label>
                    <input id="date" name="date" type="date" min="{{ now()->toDateString() }}" value="{{ old('date') }}">
                </div>
                <div class="field">
                    <label for="heure">Heure</label>
                    <input id="heure" name="heure" type="time" value="{{ old('heure') }}">
                </div>
            </div>

            <div class="field">
                <label for="points_cost">Points utilises pour ce rendez-vous</label>
                <input id="points_cost" type="number" value="{{ $appointmentCost }}" readonly>
            </div>

            <div class="doctor-card">
                Ce rendez-vous utilise <strong id="pointsCostText">{{ $appointmentCost }} points</strong>. Les points seront depenses seulement apres la confirmation du medecin.
                @if (! is_null($patientPoints))
                    <br>Solde actuel : <strong>{{ $patientPoints }} points</strong>.
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('rendezvous.index') }}" class="btn btn-outline">Retour</a>
                <button type="submit" class="btn btn-primary">Envoyer la demande</button>
            </div>
        </form>
    </div>
</div>
<script>
    const medecinSelect = document.getElementById('medecin_id');
    const pointsCostInput = document.getElementById('points_cost');
    const pointsCostText = document.getElementById('pointsCostText');

    medecinSelect?.addEventListener('change', () => {
        const selectedOption = medecinSelect.options[medecinSelect.selectedIndex];
        const pointsCost = selectedOption?.dataset.pointsCost || '{{ \App\Models\RendezVous::DEFAULT_POINTS_COST }}';

        pointsCostInput.value = pointsCost;
        pointsCostText.textContent = `${pointsCost} points`;
    });
</script>
</body>
</html>
