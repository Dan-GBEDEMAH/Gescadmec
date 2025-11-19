<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionCours extends Model
{
    use HasFactory;

    protected $table = 'sessionscours';

    protected $fillable = [
        'nom_cours', 'prix', 'niveau_id', 'date_debut', 'date_fin', 'statut_session',
    ];

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
