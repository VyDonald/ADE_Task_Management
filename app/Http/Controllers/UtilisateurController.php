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
        // Réservé aux admins
        $this->authorizeRole('admin');
        $validated = $request->validate([
            'email' => 'required|email|unique:utilisateurs',
            'mot_de_passe' => 'required|string|min:6',
            'nom' => 'required|string',
            'role' => 'required|in:admin,leader,membre',
            'competences' => 'nullable|array',
        ]);

        $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);
        $utilisateur = Utilisateur::create($validated);
        return response()->json($utilisateur, 201);
    }

    public function show(Utilisateur $utilisateur)
    {
        return response()->json($utilisateur);
    }

    public function update(Request $request, Utilisateur $utilisateur)
    {
        // Réservé aux admins ou à l'utilisateur lui-même
        if ($request->user()->role !== 'admin' && $request->user()->id !== $utilisateur->id) {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }
        $validated = $request->validate([
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id,
            'mot_de_passe' => 'nullable|string|min:6',
            'nom' => 'required|string',
            'role' => 'required|in:admin,leader,membre',
            'competences' => 'nullable|array',
        ]);

        if ($validated['mot_de_passe']) {
            $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $utilisateur->update($validated);
        return response()->json($utilisateur);
    }

    public function destroy(Utilisateur $utilisateur)
    {
        // Réservé aux admins
        $this->authorizeRole('admin');
        $utilisateur->delete();
        return response()->json(null, 204);
    }

    protected function authorizeRole($role)
    {
        if (request()->user()->role !== $role) {
            abort(403, 'Accès non autorisé');
        }
    }
    public function getCurrentUser(Request $request)
{
    return response()->json($request->user());
}
}
