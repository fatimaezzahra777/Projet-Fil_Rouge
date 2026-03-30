<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionPoint extends Model
{
    protected $table = 'transactions_points';

    protected $fillable = [
        'patient_id',
        'montant',
        'type',
        'description'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
