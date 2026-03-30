<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
