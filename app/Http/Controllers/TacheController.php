<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;

class TacheController extends Controller
{
    public function index()
    {
        return response()->json(Tache::with(['projet', 'utilisateur'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|string|in:high,medium,low',
            'statut' => 'required|string|in:a_faire,en_cours,terminee',
            'date_debut' => 'required|date',
            'date_echeance' => 'required|date|after_or_equal:date_debut',
            'competences_requises' => 'nullable|array',
            'projet_id' => 'required|exists:projets,id',
            'utilisateur_id' => 'required|exists:utilisateurs,id',
        ]);

        $tache = Tache::create($validated);
        return response()->json($tache->load(['projet', 'utilisateur']), 201);
    }

    public function show(Tache $tache)
    {
        return response()->json($tache->load(['projet', 'utilisateur'])); 
    }

    public function update(Request $request, Tache $tache)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|string|in:high,medium,low',
            'statut' => 'required|string|in:a_faire,en_cours,terminee',
            'date_debut' => 'required|date',
            'date_echeance' => 'required|date|after_or_equal:date_debut',
            'competences_requises' => 'nullable|array',
            'projet_id' => 'required|exists:projets,id',
            'utilisateur_id' => 'required|exists:utilisateurs,id',
        ]);

        $tache->update($validated);
        return response()->json($tache->load(['projet', 'utilisateur']));
    }

    public function destroy(Tache $tache)
    {
        $tache->delete();
        return response()->json(null, 204);
    }
}