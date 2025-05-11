<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:utilisateurs',
            'mot_de_passe' => 'required|string|min:6',
            'nom' => 'required|string',
            'role' => 'required|in:admin,leader,membre',
            'competences' => 'nullable|array',
        ]);
        
        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
        $utilisateur = Utilisateur::create($validated);
        $token = $utilisateur->createToken('auth_token')->plainTextToken;
        
        return response()->json(['utilisateur' => $utilisateur, 'token' => $token], 201);
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required|string',
        ]);
        
        $utilisateur = Utilisateur::where('email', $request->email)->first();
        
        if (!$utilisateur || !Hash::check($request->mot_de_passe, $utilisateur->mot_de_passe)) {
            return response()->json(['message' => 'Identifiants incorrects'], 401);
        }
        
        // Commentez ou supprimez cette partie si vous souhaitez permettre à tous les utilisateurs de se connecter
        // et pas seulement aux admins
        /*
        if ($utilisateur->role !== 'admin') {
            return response()->json(['message' => 'Accès réservé aux administrateurs'], 403);
        }
        */
        
        $token = $utilisateur->createToken('auth_token')->plainTextToken;
        return response()->json([
            'utilisateur' => $utilisateur, 
            'token' => $token,
            'message' => 'Connexion réussie'
        ], 200);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}