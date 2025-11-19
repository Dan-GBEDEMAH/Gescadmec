<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            // Clé vers la table 'etudiants' (qui fonctionne, car Laravel devine 'etudiants')
            $table->foreignId('etudiant_id')->constrained()->onDelete('cascade');
            
            // Clé vers la table 'sessionscours' (CORRIGÉE avec le nom explicite)
            $table->foreignId('sessioncours_id')
                  ->constrained('sessionscours') // <--- SPÉCIFIER LE NOM PLURIEL
                  ->onDelete('cascade');
                  
            $table->decimal('montant_total', 10, 2);
            $table->decimal('montant_verse', 10, 2)->default(0);
            $table->decimal('reste_payer', 10, 2)->default(0);
            $table->enum('statut_paiement', ['soldé', 'non soldé'])->default('non soldé');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};