<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;

class ProjetController extends Controller
{
    public function index()
    {
        return response()->json(Projet::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'equipe_id' => 'required|exists:equipes,id',
        ]);

        $projet = Projet::create($validated);
        return response()->json($projet, 201);
    }

    public function show(Projet $projet)
    {
        return response()->json($projet);
    }

    public function update(Request $request, Projet $projet)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'equipe_id' => 'required|exists:equipes,id',
        ]);

        $projet->update($validated);
        return response()->json($projet);
    }

    public function destroy(Projet $projet)
    {
        $projet->delete();
        return response()->json(null, 204);
    }
}
