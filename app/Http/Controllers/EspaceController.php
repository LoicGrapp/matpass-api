<?php

namespace App\Http\Controllers;

use App\Models\Espace;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EspaceController extends Controller
{
    /**
     * Liste des espaces de la salle.
     */
    public function index(): JsonResponse
    {
        return response()->json(Espace::orderBy('name')->get());
    }

    /**
     * Création d'un espace (réservé à l'admin).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $espace = Espace::create($data);

        return response()->json($espace, 201);
    }
}
