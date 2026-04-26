<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Activite extends Model
{
    protected $fillable = [
        'association_id',
        'titre',
        'description',
        'date',
        'points'
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public static function Fin(): void
    {
        $expiredActivities = static::query()
            ->with(['participations.patient'])
            ->whereDate('date', '<', now()->toDateString())
            ->get();

        foreach ($expiredActivities as $activite) {
            DB::transaction(function () use ($activite) {
                $acceptedParticipations = $activite->participations
                    ->where('statut', 'accepte')
                    ->filter(fn ($participation) => $participation->patient);

                foreach ($acceptedParticipations as $participation) {
                    $patient = $participation->patient;
                    $points = (int) $activite->points;

                    $patient->increment('points', $points);

                    TransactionPoint::create([
                        'patient_id' => $patient->id,
                        'montant' => $points,
                        'type' => 'gain',
                        'description' => 'Points gagnes apres participation a l activite "' . $activite->titre . '"',
                    ]);
                }

                $activite->delete();
            });
        }
    }
}
