<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;

class TacheController extends Controller
{
    public function index()
    {
        return response()->json(Tache::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|string',
            'statut' => 'required|string',
            'date_echeance' => 'nullable|date',
            'competences_requises' => 'nullable|array',
            'projet_id' => 'required|exists:projets,id',
        ]);

        $tache = Tache::create($validated);
        return response()->json($tache, 201);
    }

    public function show(Tache $tache)
    {
        return response()->json($tache);
    }

    public function update(Request $request, Tache $tache)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'required|string',
            'statut' => 'required|string',
            'date_echeance' => 'nullable|date',
            'competences_requises' => 'nullable|array',
            'projet_id' => 'required|exists:projets,id',
        ]);

        $tache->update($validated);
        return response()->json($tache);
    }

    public function destroy(Tache $tache)
    {
        $tache->delete();
        return response()->json(null, 204);
    }
}
