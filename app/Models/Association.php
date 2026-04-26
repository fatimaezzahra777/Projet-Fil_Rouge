<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'description',
        'is_validated'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activites()
    {
        return $this->hasMany(Activite::class);
    }
}
