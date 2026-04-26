<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    public const DEFAULT_APPOINTMENT_POINTS_COST = 20;

    protected $fillable = [
        'user_id',
        'specialite',
        'appointment_points_cost',
        'points',
        'is_validated'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
}
