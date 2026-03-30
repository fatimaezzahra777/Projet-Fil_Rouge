<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = [
        'patient_id',
        'activite_id',
        'statut'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }
}
