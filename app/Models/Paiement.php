<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id', 'montant_verse', 'date_paiement',
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
    ];

    // Relation : un paiement appartient à une inscription
    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}