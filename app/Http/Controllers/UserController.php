<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Liste des utilisateurs, avec filtre optionnel par rôle (?role=coach).
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query()->latest();

        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        return response()->json($query->get());
    }

    /**
     * Création d'un utilisateur par l'admin (typiquement un coach).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,coach,member'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // haché automatiquement par le modèle User.
            'role' => $data['role'],
            'phone' => $data['phone'] ?? null,
            'status' => 'active',
        ]);

        return response()->json($user, 201);
    }

    /**
     * Mise à jour d'un utilisateur : nom, téléphone, rôle, statut (actif/désactivé).
     * Les champs absents de la requête ne sont pas modifiés.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'role' => ['sometimes', 'in:admin,coach,member'],
            'status' => ['sometimes', 'in:active,disabled'],
        ]);

        // Sécurité : on ne peut pas changer son propre rôle ni son propre statut
        // (évite de se verrouiller dehors ou de se rétrograder par erreur).
        if ($user->is($request->user())) {
            unset($data['role'], $data['status']);
        }

        $user->update($data);

        return response()->json($user);
    }
}
