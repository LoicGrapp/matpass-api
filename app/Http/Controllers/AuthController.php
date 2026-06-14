<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Connexion : vérifie les identifiants et renvoie un token d'accès.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Email inconnu ou mauvais mot de passe : même message pour ne pas
        // révéler lequel des deux est faux.
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Identifiants incorrects.',
            ]);
        }

        // Compte désactivé : on refuse la connexion.
        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => 'Ce compte est désactivé.',
            ]);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Déconnexion : supprime le token utilisé pour cette requête.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté.']);
    }

    /**
     * Renvoie l'utilisateur actuellement connecté.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
