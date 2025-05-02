<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipe;


class EquipeController extends Controller
{
    public function index()
    {
        return response()->json(Equipe::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
        ]);

        $equipe = Equipe::create($validated);
        return response()->json($equipe, 201);
    }

    public function show(Equipe $equipe)
    {
        return response()->json($equipe);
    }

    public function update(Request $request, Equipe $equipe)
    {
        $validated = $request->validate([
            'nom' => 'required|string',
        ]);

        $equipe->update($validated);
        return response()->json($equipe);
    }

    public function destroy(Equipe $equipe)
    {
        $equipe->delete();
        return response()->json(null, 204);
    }
}
