<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation rendez-vous</title>
</head>
<body style="margin:0;padding:0;background:#f4f7f5;font-family:Arial,sans-serif;color:#0D1F1E;">
    <div style="max-width:640px;margin:0 auto;padding:32px 18px;">
        <div style="background:linear-gradient(135deg,#143C3C 0%,#235347 60%,#8EB69B 100%);border-radius:28px;padding:32px;color:#ffffff;">
            <div style="font-size:13px;letter-spacing:.16em;text-transform:uppercase;opacity:.75;">Second Chance</div>
            <h1 style="margin:14px 0 10px;font-size:30px;line-height:1.2;font-family:Georgia,serif;">Votre rendez-vous est confirmé</h1>
            <p style="margin:0;font-size:15px;line-height:1.8;color:rgba(255,255,255,.88);">
                Bonjour {{ $rendezVous->patient?->user?->prenom ?? 'cher patient' }}, votre rendez-vous a bien été confirmé.
            </p>
        </div>

        <div style="background:#ffffff;border-radius:24px;padding:28px;margin-top:20px;box-shadow:0 10px 30px rgba(5,31,32,.06);">
            <h2 style="margin:0 0 18px;font-size:20px;color:#235347;">Détails du rendez-vous</h2>

            <table style="width:100%;border-collapse:collapse;">
                <tr>
                    <td style="padding:12px 0;border-bottom:1px solid #E3ECE7;color:#7A9E93;font-size:14px;">Médecin</td>
                    <td style="padding:12px 0;border-bottom:1px solid #E3ECE7;color:#0D1F1E;font-size:14px;font-weight:700;text-align:right;">
                        Dr. {{ $rendezVous->medecin?->user?->prenom }} {{ $rendezVous->medecin?->user?->nom }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:12px 0;border-bottom:1px solid #E3ECE7;color:#7A9E93;font-size:14px;">Spécialité</td>
                    <td style="padding:12px 0;border-bottom:1px solid #E3ECE7;color:#0D1F1E;font-size:14px;font-weight:700;text-align:right;">
                        {{ $rendezVous->medecin?->specialite ?: 'Consultation' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:12px 0;border-bottom:1px solid #E3ECE7;color:#7A9E93;font-size:14px;">Date</td>
                    <td style="padding:12px 0;border-bottom:1px solid #E3ECE7;color:#0D1F1E;font-size:14px;font-weight:700;text-align:right;">
                        {{ \Illuminate\Support\Carbon::parse($rendezVous->date)->format('d/m/Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:12px 0;border-bottom:1px solid #E3ECE7;color:#7A9E93;font-size:14px;">Heure</td>
                    <td style="padding:12px 0;border-bottom:1px solid #E3ECE7;color:#0D1F1E;font-size:14px;font-weight:700;text-align:right;">
                        {{ substr($rendezVous->heure, 0, 5) }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:12px 0;color:#7A9E93;font-size:14px;">Lieu</td>
                    <td style="padding:12px 0;color:#0D1F1E;font-size:14px;font-weight:700;text-align:right;">
                        {{ $lieu }}
                    </td>
                </tr>
            </table>

            <p style="margin:22px 0 0;font-size:14px;line-height:1.8;color:#3A5A52;">
                Pensez à vous présenter quelques minutes avant l’horaire prévu. Si vous avez besoin de modifier ce rendez-vous, connectez-vous à votre espace patient.
            </p>
        </div>
    </div>
</body>
</html>
