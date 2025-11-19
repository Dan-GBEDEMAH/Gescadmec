<?php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class Besoincontroller extends Controller
{
    public function index()
    {
        $besoins = Besoin::with('etudiant')->latest()->paginate(10);
        $etudiants = Etudiant::orderBy('prenom')->orderBy('nom')->get();
        return view('admin.besoins.index', compact('besoins', 'etudiants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'description' => 'required|string|max:1000',
        ]);

        Besoin::create($validated);

        return redirect()->route('besoins.index')->with('success', 'Besoin enregistré.');
    }
}
