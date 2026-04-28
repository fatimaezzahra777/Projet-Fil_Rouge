<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un rendez-vous</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --gm:#235347; --gl:#8EB69B; --wh:#fff; --cr:#F4F7F5; --td:#0D1F1E; --tl:#7A9E93; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'DM Sans',sans-serif; background:var(--cr); color:var(--td); }
        .wrap { max-width:860px; margin:0 auto; padding:34px 18px 48px; }
        .card { background:#fff; border-radius:24px; padding:28px; box-shadow:0 10px 30px rgba(5,31,32,.06); }
        h1 { font-family:'Playfair Display',serif; font-size:2rem; margin-bottom:6px; }
        .sub { color:var(--tl); margin-bottom:24px; }
        .grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        .field { margin-bottom:18px; }
        label { display:block; margin-bottom:8px; font-weight:700; font-size:.88rem; }
        select, input { width:100%; border:1px solid #d6e2db; border-radius:15px; padding:14px 16px; font:inherit; background:#fff; }
        .actions { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-top:8px; }
        .btn { display:inline-flex; align-items:center; justify-content:center; padding:11px 18px; border-radius:999px; text-decoration:none; font-weight:700; font-size:.86rem; }
        .btn-primary { background:var(--gm); color:#fff; border:none; cursor:pointer; }
        .btn-outline { border:1.5px solid var(--gm); color:var(--gm); background:transparent; }
        .errors { margin-bottom:18px; padding:14px 16px; border-radius:14px; background:#fff1f1; border:1px solid #ffd0d0; color:#9a3535; font-size:.9rem; }
        .errors ul { padding-left:18px; }
        @media (max-width: 720px) { .grid { grid-template-columns:1fr; } .actions { flex-direction:column; align-items:stretch; } }
    </style>
</head>
<body>
@php
    $user = auth()->user();
    $appointmentCost = $rendezVous->points_cost ?? \App\Models\RendezVous::DEFAULT_POINTS_COST;
    $doctorCosts = ($doctorCosts ?? collect())->toArray();
@endphp
<div class="wrap">
    <div class="card">
        <h1>Modifier le rendez-vous</h1>
        <p class="sub">Mettez a jour les informations de ce rendez-vous selon votre role.</p>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('rendezvous.update', $rendezVous) }}">
            @csrf
            @method('PUT')

            @if ($user->hasRole('admin'))
                <div class="field">
                    <label for="patient_id">Patient</label>
                    <select id="patient_id" name="patient_id">
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" @selected(old('patient_id', $rendezVous->patient_id) == $patient->id)>
                                {{ $patient->user?->prenom }} {{ $patient->user?->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="field">
                <label for="medecin_id">Medecin</label>
                <select id="medecin_id" name="medecin_id">
                    @foreach ($medecins as $medecin)
                        <option value="{{ $medecin->id }}" data-points-cost="{{ $doctorCosts[$medecin->id] ?? \App\Models\RendezVous::DEFAULT_POINTS_COST }}" @selected(old('medecin_id', $rendezVous->medecin_id) == $medecin->id)>
                            Dr. {{ $medecin->user?->prenom }} {{ $medecin->user?->nom }} - {{ $medecin->specialite }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid">
                <div class="field">
                    <label for="date">Date</label>
                    <input id="date" name="date" type="date" value="{{ old('date', $rendezVous->date) }}">
                </div>
                <div class="field">
                    <label for="heure">Heure</label>
                    <input id="heure" name="heure" type="time" value="{{ old('heure', substr($rendezVous->heure, 0, 5)) }}">
                </div>
            </div>

            <div class="field">
                <label for="statut">Statut</label>
                <select id="statut" name="statut">
                    @foreach (['en_attente' => 'En attente', 'confirme' => 'Confirme', 'annule' => 'Annule'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('statut', $rendezVous->statut) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="points_cost">Points utilises pour ce rendez-vous</label>
                <input id="points_cost" type="number" value="{{ $appointmentCost }}" readonly>
            </div>

            <div class="actions">
                <a href="{{ route('rendezvous.index') }}" class="btn btn-outline">Retour</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<script>
    const medecinSelect = document.getElementById('medecin_id');
    const pointsCostInput = document.getElementById('points_cost');

    medecinSelect?.addEventListener('change', () => {
        const selectedOption = medecinSelect.options[medecinSelect.selectedIndex];
        pointsCostInput.value = selectedOption?.dataset.pointsCost || '{{ \App\Models\RendezVous::DEFAULT_POINTS_COST }}';
    });
</script>
</body>
</html>
