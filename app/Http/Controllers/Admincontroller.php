<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Paiement;
use App\Models\sessioncours;
use Illuminate\Http\Request;

class AdminController extends Controller
{

      /**
     * Afficher le tableau de bord admin
     */
 public function dashboard()
    {
        // Inscrits ce mois
        $inscritsMois = Etudiant::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();

        // Total encaissé
        $totalEncaisse = Paiement::sum('montant_verse');

        // Soldes en attente (total des restes à payer)
        $soldesAttente = \App\Models\Inscription::sum('reste_payer');

        // Sessions actives
        $sessionsActives = sessioncours::where('statut_session', 'en cours')->count();

        // Paiements récents (5 derniers)
        $paiementsRecents = Paiement::with(['inscription.etudiant'])
                                    ->latest('date_paiement')
                                    ->take(5)
                                    ->get();

        return view('admin.dashboard', compact(
            'inscritsMois',
            'totalEncaisse',
            'soldesAttente',
            'sessionsActives',
            'paiementsRecents'
        ));
    }


}
