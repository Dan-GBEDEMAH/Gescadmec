<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Niveau;
use App\Models\SessionCours;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user
        if (!User::where('email', 'admin@gescadmec.com')->exists()) {
            User::create([
                'email' => 'admin@gescadmec.com',
                'password' => Hash::make('secret'), 
                'role' => 'admin',
            ]);
        }

        // Seed niveaux
        $levels = ['Débutant','Intermédiaire','Avancé'];
        foreach ($levels as $profil) {
            Niveau::firstOrCreate(['profil' => $profil]);
        }

        // Seed course sessions with names
        $niveau = Niveau::firstOrCreate(['profil' => 'Intermédiaire']);
        $baseStart = now()->startOfMonth();
        $courses = [
            ['nom' => 'Cours d\'Allemand', 'prix' => 150000, 'debut' => $baseStart, 'fin' => (clone $baseStart)->addWeeks(8)],
            ['nom' => 'Cours de Chinois', 'prix' => 200000, 'debut' => (clone $baseStart)->addWeeks(1), 'fin' => (clone $baseStart)->addWeeks(9)],
            ['nom' => 'Cours d\'Espagnol', 'prix' => 180000, 'debut' => (clone $baseStart)->addWeeks(2), 'fin' => (clone $baseStart)->addWeeks(10)],
            ['nom' => 'Cours d\'Italien', 'prix' => 175000, 'debut' => (clone $baseStart)->addWeeks(3), 'fin' => (clone $baseStart)->addWeeks(11)],
            ['nom' => 'Cours de Japonais', 'prix' => 220000, 'debut' => (clone $baseStart)->addWeeks(4), 'fin' => (clone $baseStart)->addWeeks(12)],
        ];

        foreach ($courses as $c) {
            SessionCours::firstOrCreate(
                [
                    'nom_cours' => $c['nom'],
                    'niveau_id' => $niveau->id,
                    'date_debut' => $c['debut']->toDateString(),
                    'date_fin' => $c['fin']->toDateString(),
                ],
                [
                    'prix' => $c['prix'],
                    'statut_session' => 'en cours',
                ]
            );
        }
    }
}
