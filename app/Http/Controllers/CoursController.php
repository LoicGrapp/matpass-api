<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CoursController extends Controller
{
    /**
     * Liste des cours, avec leur espace et leur coach.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Cours::with(['espace', 'coach'])->orderBy('name')->get()
        );
    }

    /**
     * Création d'un cours (réservé à l'admin).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sport_type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'espace_id' => ['required', 'exists:espaces,id'],
            // Le coach doit être un utilisateur ayant le rôle "coach".
            'coach_id' => ['required', Rule::exists('users', 'id')->where('role', 'coach')],
            'max_participants' => ['required', 'integer', 'min:1'],
            'status' => ['nullable', 'in:active,cancelled'],
        ]);

        $cours = Cours::create($data);

        return response()->json($cours->load(['espace', 'coach']), 201);
    }
}
