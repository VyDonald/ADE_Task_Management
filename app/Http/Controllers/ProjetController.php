<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;

class ProjetController extends Controller
{
    public function index()
    {
        // Leaders et membres voient seulement leurs projets
        if (request()->user()->role === 'membre' || request()->user()->role === 'leader') {
            $projets = request()->user()->equipes->flatMap->projets;
            return response()->json($projets);
        }
        return response()->json(Projet::all());
    }

    public function store(Request $request)
    {
        // Réservé aux admins et leaders
        $this->authorizeRole(['admin', 'leader']);
        $validated = $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'equipe_id' => 'required|exists:equipes,id',
        ]);

        // Vérifier que le leader appartient à l'équipe
        if ($request->user()->role === 'leader' && !$request->user()->equipes->contains($validated['equipe_id'])) {
            return response()->json(['error' => 'Vous ne faites pas partie de cette équipe'], 403);
        }

        $projet = Projet::create($validated);
        return response()->json($projet, 201);
    }

    public function show(Projet $projet)
    {
        // Vérifier que l'utilisateur a accès au projet
        $this->authorizeProjet($projet);
        return response()->json($projet);
    }

    public function update(Request $request, Projet $projet)
    {
        // Réservé aux admins et leaders
        $this->authorizeRole(['admin', 'leader']);
        $this->authorizeProjet($projet);
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
        // Réservé aux admins et leaders
        $this->authorizeRole(['admin', 'leader']);
        $this->authorizeProjet($projet);
        $projet->delete();
        return response()->json(null, 204);
    }

    protected function authorizeRole($roles)
    {
        if (!in_array(request()->user()->role, (array)$roles)) {
            abort(403, 'Accès non autorisé');
        }
    }

    protected function authorizeProjet(Projet $projet)
    {
        if (request()->user()->role === 'membre' || request()->user()->role === 'leader') {
            if (!request()->user()->equipes->contains($projet->equipe_id)) {
                abort(403, 'Vous n\'avez pas accès à ce projet');
            }
        }
    }
}
