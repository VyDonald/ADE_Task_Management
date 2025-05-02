<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;

class UtilisateurController extends Controller
{
    public function index()
    {
        return response()->json(Utilisateur::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:utilisateurs',
            'mot_de_passe' => 'required|string|min:6',
            'nom' => 'required|string',
            'role' => 'required|string',
            'competences' => 'nullable|array',
        ]);

        $utilisateur = Utilisateur::create($validated);
        return response()->json($utilisateur, 201);
    }

    public function show(Utilisateur $utilisateur)
    {
        return response()->json($utilisateur);
    }

    public function update(Request $request, Utilisateur $utilisateur)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id,
            'mot_de_passe' => 'nullable|string|min:6',
            'nom' => 'required|string',
            'role' => 'required|string',
            'competences' => 'nullable|array',
        ]);

        $utilisateur->update($validated);
        return response()->json($utilisateur);
    }

    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();
        return response()->json(null, 204);
    }
}
