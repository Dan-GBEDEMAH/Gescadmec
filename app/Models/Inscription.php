<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id', 'sessioncours_id', 'montant_total', 'montant_verse', 'reste_payer', 'statut_paiement', 'statut_etudiant',
    ];

    // Relation : une inscription appartient à un étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    // Relation : une inscription appartient à une session
    public function sessionCours()
    {
        return $this->belongsTo(SessionCours::class, 'sessioncours_id');
    }

    //Relation : une inscription a plusieurs paiements
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}