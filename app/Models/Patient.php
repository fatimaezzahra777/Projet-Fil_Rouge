<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'type_addiction',
        'points'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function transactions()
    {
        return $this->hasMany(TransactionPoint::class);
    }
}
