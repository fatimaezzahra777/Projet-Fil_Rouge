<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    public const DEFAULT_POINTS_COST = 20;
    public const FIXED_POINTS_COST = self::DEFAULT_POINTS_COST;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date',
        'heure',
        'statut',
        'points_cost',
        'patient_points_spent',
        'medecin_points_awarded',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
}
