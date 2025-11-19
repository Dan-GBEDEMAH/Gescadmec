<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\SessionCours;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    // Liste des étudiants
    public function index(Request $request)
    {
        $query = Etudiant::query()->with(['inscriptions.sessionCours', 'inscriptions.paiements']);

        // Filtre par niveau si spécifié
        if ($request->has('niveau') && $request->niveau != '') {
            $query->where('niveau', $request->niveau);
        }

        // Filtre par recherche
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('prenom', 'like', "%$search%")
                  ->orWhere('nom', 'like', "%$search%")
                  ->orWhere('telephone', 'like', "%$search%");
            });
        }

        // Filtre par statut de paiement
        if ($request->has('statut_paiement') && $request->statut_paiement != '') {
            $status = $request->statut_paiement === 'paye' ? 'soldé' : ($request->statut_paiement === 'reste' ? 'non soldé' : null);
            if ($status) {
                $query->whereHas('inscriptions', function($q) use ($status) {
                    $q->where('statut_paiement', $status);
                });
            }
        }

        // Filtre par statut de cours
        if ($request->has('statut_session') && $request->statut_session != '') {
            $sess = $request->statut_session === 'termine' ? 'terminé' : 'en cours';
            $query->whereHas('inscriptions', function($q) use ($sess) {
                $q->whereHas('sessionCours', function($qs) use ($sess) {
                    $qs->where('statut_session', $sess);
                });
            });
        }

        $etudiants = $query->latest()->paginate(10);
        return view('admin.etudiants.index', compact('etudiants'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $sessions = SessionCours::all();
        return view('admin.etudiants.create', compact('sessions'));
    }

    // Enregistrer un étudiant
    public function store(Request $request)
{
    $validated = $request->validate([
        'prenom' => 'required',
        'nom' => 'required',
        'date_naissance' => 'required|date',
        'telephone' => 'unique:etudiants,telephone',
        'adresse' => 'required',
        'niveau' => 'required',
        'sessioncours_id' => 'required|exists:sessionscours,id',
        'montant_total' => 'required|numeric|min:0',
        'montant_verse' => 'required|numeric|min:0',
    ]);

    $etudiantExistant = Etudiant::where('nom', $request->nom)
                                ->where('prenom', $request->prenom)
                                ->first();

    if ($etudiantExistant) {
        return back()->withErrors([
            'general' => 'Cet étudiant (nom et prénom) est déjà enregistré.',
            'nom' => 'Ce nom et prénom existent déjà.',
        ])->withInput();
    }

    $etudiant = Etudiant::create($validated);

    $montantVerse = $request->montant_verse ?? 0;
    $restePayer = max(0, $request->montant_total - $montantVerse);
    $statutPaiement = $restePayer <= 0 ? 'soldé' : 'non soldé';

    $inscription = Inscription::create([
        'etudiant_id' => $etudiant->id,
        'sessioncours_id' => $request->sessioncours_id,
        'montant_total' => $request->montant_total,
        'montant_verse' => $montantVerse,
        'reste_payer' => $restePayer,
        'statut_paiement' => $statutPaiement,
       
    ]);

    // Créer un paiement initial si l'étudiant a versé de l'argent
    if ($montantVerse > 0) {
        \App\Models\Paiement::create([
            'inscription_id' => $inscription->id,
            'montant_verse' => $montantVerse,
            'date_paiement' => now(),
        ]);
    }

    return redirect()->route('etudiants.index')->with('success', 'Étudiant ajouté avec succès. Procédez au paiement si nécessaire.');
}

    // Afficher un étudiant
    public function show(Etudiant $etudiant)
    {
        $etudiant->load(['inscriptions.sessionCours', 'inscriptions.paiements']);
        
        // Calculer les totaux pour toutes les inscriptions en utilisant les paiements réels
        $totalDu = $etudiant->inscriptions->sum('montant_total');
        
        // Calculer le total versé en sommant tous les paiements de toutes les inscriptions
        $totalVerse = 0;
        foreach ($etudiant->inscriptions as $inscription) {
            $totalVerse += $inscription->paiements->sum('montant_verse');
        }
        
        // Calculer le reste à payer
        $totalReste = max(0, $totalDu - $totalVerse);
        
        // Charger toutes les sessions disponibles pour l'inscription
        $sessions = SessionCours::all();
        
        return view('admin.etudiants.show', compact('etudiant', 'totalDu', 'totalVerse', 'totalReste', 'sessions'));
    }

    // Afficher le formulaire de mise à jour
    public function edit(Etudiant $etudiant)
    {
        return view('admin.etudiants.edit', compact('etudiant'));
    }

    // Modifier un étudiant
    public function update(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'prenom' => 'required',
            'nom' => 'required',
            'date_naissance' => 'required|date',
            'telephone' => 'unique:etudiants',
            'adresse' => 'required',
            'niveau' => 'required'  
        ]);

        $etudiant->update($validated);

        return redirect()->route('etudiants.index')->with('success', 'Étudiant modifié avec succès.');
    }

    // Supprimer un étudiant
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }

    // API: Récupérer les inscriptions d'un étudiant
    public function getInscriptions(Etudiant $etudiant)
    {
        $inscriptions = $etudiant->inscriptions()->with('sessionCours')->get();
        return response()->json($inscriptions);
    }

    // Ajouter une inscription à un étudiant existant
    public function addInscription(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'sessioncours_id' => 'required|exists:sessionscours,id',
            'montant_total' => 'required|numeric|min:0',
        ]);

        $inscription = Inscription::create([
            'etudiant_id' => $etudiant->id,
            'sessioncours_id' => $validated['sessioncours_id'],
            'montant_total' => $validated['montant_total'],
            'montant_verse' => 0,
            'reste_payer' => $validated['montant_total'],
            'statut_paiement' => 'non soldé',
            'statut_etudiant' => 'en cours',
        ]);

        return redirect()->route('etudiants.show', $etudiant->id)->with('success', 'Inscription ajoutée avec succès.');
    }
}