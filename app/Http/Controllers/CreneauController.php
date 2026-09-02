<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Creneau;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CreneauController extends Controller
{
    /**
     * Liste des créneaux (avec le cours, son espace et son coach),
     * filtre optionnel par cours (?cours_id=). Sert de base au planning.
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $query = Creneau::with('cours', 'espace', 'coach')
            // Nombre de places déjà prises (réservations confirmées).
            ->withCount(['reservations as reserved_count' => fn ($q) => $q->where('status', 'confirmed')])
            // Vaut 1 si l'utilisateur connecté a déjà réservé ce créneau, sinon 0.
            ->withCount(['reservations as reserved_by_me' => fn ($q) => $q->where('status', 'confirmed')->where('user_id', $userId)])
            ->orderBy('date')
            ->orderBy('start_time');

        if ($coursId = $request->query('cours_id')) {
            $query->where('cours_id', $coursId);
        }

        // ?mine=1 : uniquement les créneaux du coach connecté (son espace coach).
        if ($request->boolean('mine')) {
            $query->where('coach_id', $userId);
        }

        // ?date=YYYY-MM-DD : le planning d'une journée précise.
        if ($date = $request->query('date')) {
            $query->whereDate('date', $date);
        }

        return response()->json($query->get());
    }

    /**
     * Création d'un créneau (réservé à l'admin).
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'cours_id' => ['required', 'exists:cours,id'],
            'espace_id' => ['nullable', 'exists:espaces,id'],
            // Le coach assigné doit être un utilisateur ayant le rôle "coach".
            'coach_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'coach')],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'places' => ['nullable', 'integer', 'min:1'],
        ]);

        // Valeurs non fournies : on reprend celles du cours par défaut.
        $cours = Cours::findOrFail($data['cours_id']);
        $data['espace_id'] = $data['espace_id'] ?? $cours->espace_id;
        $data['coach_id'] = $data['coach_id'] ?? $cours->coach_id;
        $data['places'] = $data['places'] ?? $cours->max_participants;

        $creneau = Creneau::create($data);

        return response()->json($creneau->load('cours', 'espace', 'coach'), 201);
    }

    /**
     * Les membres inscrits sur un créneau, avec leur statut de présence.
     * Réservé au coach du créneau : c'est sa liste d'appel.
     */
    public function reservations(Request $request, Creneau $creneau): JsonResponse
    {
        if ($creneau->coach_id !== $request->user()->id) {
            abort(403, "Ce créneau n'est pas le vôtre.");
        }

        $reservations = $creneau->reservations()
            ->whereIn('status', ['confirmed', 'present'])
            ->with('user')
            ->get();

        return response()->json($reservations);
    }
}
