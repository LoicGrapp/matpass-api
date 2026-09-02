<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class PresenceController extends Controller
{
    /**
     * Tolérance avant le début du cours : les membres arrivent en avance,
     * le coach scanne pendant qu'ils entrent.
     * ponytail: valeur en dur, à passer en paramètre global si la salle veut la régler.
     */
    private const TOLERANCE_MINUTES = 30;

    /**
     * Validation d'une présence : le coach scanne le QR code du membre.
     * Les cinq contrôles du chapitre 10.3 du dossier sont appliqués ici.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
        ]);

        // ① Le jeton est-il valide ? (signature produite avec la clé de l'app)
        $reservation = Reservation::findByToken($data['token']);

        if (! $reservation) {
            $this->refuser('QR code invalide.');
        }

        $creneau = $reservation->creneau;

        // ② La réservation est-elle confirmée ? (ni annulée, ni déjà validée)
        if ($reservation->status !== 'confirmed') {
            $this->refuser($reservation->status === 'present'
                ? 'Cette présence a déjà été validée.'
                : 'Cette réservation a été annulée.');
        }

        // ③ Le créneau est-il bien celui du coach qui scanne ?
        if ($creneau->coach_id !== $request->user()->id) {
            abort(403, "Ce créneau n'est pas le vôtre.");
        }

        // ④ Est-on dans la fenêtre horaire du cours ?
        $jour = $creneau->date->format('Y-m-d');
        $debut = Carbon::parse("{$jour} {$creneau->start_time}")->subMinutes(self::TOLERANCE_MINUTES);
        $fin = Carbon::parse("{$jour} {$creneau->end_time}");

        if (! now()->between($debut, $fin)) {
            $this->refuser("Ce cours n'a pas lieu en ce moment.");
        }

        // ⑤ Les cinq contrôles sont passés : la présence est enregistrée.
        $reservation->update(['status' => 'present']);

        return response()->json([
            'message' => 'Présence validée.',
            'reservation' => $reservation->load('user', 'creneau.cours'),
        ]);
    }

    /**
     * Refus métier : message affiché tel quel au coach dans l'écran de scan.
     */
    private function refuser(string $message): never
    {
        throw ValidationException::withMessages(['token' => $message]);
    }
}
