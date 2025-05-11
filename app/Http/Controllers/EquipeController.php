<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipe;
use App\Models\Utilisateur;

class EquipeController extends Controller
{
    public function index()
    {
        // Récupérer toutes les équipes avec leurs utilisateurs associés
        return response()->json(Equipe::with('utilisateurs')->get());
    }

    public function store(Request $request)
    {
        // Réservé aux admins
        $this->authorizeRole('admin');
        $validated = $request->validate([
            'nom' => 'required|string',
        ]);

        $equipe = Equipe::create($validated);
        return response()->json($equipe, 201);
    }

    public function show(Equipe $equipe)
    {
        // Charger également les utilisateurs de l'équipe
        $equipe->load('utilisateurs');
        return response()->json($equipe);
    }

    public function update(Request $request, Equipe $equipe)
    {
        // Réservé aux admins
        $this->authorizeRole('admin');
        $validated = $request->validate([
            'nom' => 'required|string',
        ]);

        $equipe->update($validated);
        return response()->json($equipe);
    }

    public function destroy(Equipe $equipe)
    {
        // Réservé aux admins
        $this->authorizeRole('admin');
        $equipe->delete();
        return response()->json(null, 204);
    }

    /**
     * Attacher un utilisateur à une équipe
     */
    public function attachUtilisateur(Request $request, Equipe $equipe)
    {
        // Réservé aux admins
        $this->authorizeRole('admin');
        
        $validated = $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
        ]);

        // Récupérer l'utilisateur
        $utilisateur = Utilisateur::findOrFail($validated['utilisateur_id']);
        
        // Attacher l'utilisateur à l'équipe
        $equipe->utilisateurs()->attach($utilisateur->id);
        
        // Recharger l'équipe avec ses utilisateurs
        $equipe->load('utilisateurs');
        
        return response()->json($equipe);
    }

    /**
     * Détacher un utilisateur d'une équipe
     */
    public function detachUtilisateur(Request $request, Equipe $equipe, Utilisateur $utilisateur)
    {
        // Réservé aux admins
        $this->authorizeRole('admin');
        
        // Détacher l'utilisateur de l'équipe
        $equipe->utilisateurs()->detach($utilisateur->id);
        
        // Recharger l'équipe avec ses utilisateurs
        $equipe->load('utilisateurs');
        
        return response()->json($equipe);
    }

    protected function authorizeRole($role)
    {
        if (request()->user()->role !== $role) {
            abort(403, 'Accès non autorisé');
        }
    }
}