<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
         'nom','prenom', 'date_naissance', 'telephone', 'adresse',  'niveau'
    ];


    // Relation : un étudiant peut avoir plusieurs inscriptions
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // Relation : un étudiant peut exprimer plusieurs besoins
    public function besoins()
    {
        return $this->hasMany(Besoin::class);
    }
}