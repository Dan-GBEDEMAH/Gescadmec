<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Paiementcontroller extends Controller
{
    public function index()
    {
        $paiements = Paiement::with(['inscription.etudiant', 'inscription.sessionCours'])
            ->latest()
            ->paginate(15);
        return view('admin.paiements.index', compact('paiements'));
    }

    public function create(\App\Models\Etudiant $etudiant)
    {
        return view('admin.paiements.create', compact('etudiant'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'montant_verse' => 'required|numeric|min:0',
        ]);

        $inscription = Inscription::findOrFail($validated['inscription_id']);

        // Créer le paiement
        $paiement = Paiement::create([
            'inscription_id' => $inscription->id,
            'montant_verse' => $validated['montant_verse'],
            'date_paiement' => now(),
        ]);

        // Recalculer le total versé en sommant TOUS les paiements de cette inscription
        $nouveauMontantVerse = $inscription->paiements()->sum('montant_verse');
        $reste = max(0, $inscription->montant_total - $nouveauMontantVerse);

        // Mettre à jour l'inscription avec les nouvelles valeurs
        $inscription->update([
            'montant_verse' => $nouveauMontantVerse,
            'reste_payer' => $reste,
            'statut_paiement' => $reste <= 0 ? 'soldé' : 'non soldé',
        ]);

        return view('admin.paiements.receipt', compact('paiement', 'inscription'));
    }

    public function showReceipt(Paiement $paiement)
    {
        $paiement->load(['inscription.etudiant', 'inscription.sessionCours']);
        $inscription = $paiement->inscription;
        return view('admin.paiements.receipt', compact('paiement', 'inscription'));
    }
}
