<?php

namespace App\Http\Controllers;

use App\Models\Creneau;
use App\Models\Reservation;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    /**
     * Les réservations de l'utilisateur connecté.
     */
    public function index(Request $request): JsonResponse
    {
        $reservations = $request->user()
            ->reservations()
            ->with('creneau.cours', 'creneau.espace', 'creneau.coach')
            ->latest()
            ->get();

        return response()->json($reservations);
    }

    /**
     * Réserver un créneau pour l'utilisateur connecté.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'creneau_id' => ['required', 'exists:creneaux,id'],
        ]);

        $user = $request->user();
        $creneau = Creneau::findOrFail($data['creneau_id']);

        // Déjà une réservation active sur ce créneau ?
        $dejaReserve = Reservation::where('user_id', $user->id)
            ->where('creneau_id', $creneau->id)
            ->where('status', 'confirmed')
            ->exists();

        if ($dejaReserve) {
            throw ValidationException::withMessages([
                'creneau_id' => 'Vous avez déjà réservé ce créneau.',
            ]);
        }

        // Reste-t-il de la place ? (places du créneau - réservations confirmées)
        $placesPrises = Reservation::where('creneau_id', $creneau->id)
            ->where('status', 'confirmed')
            ->count();

        if ($placesPrises >= $creneau->places) {
            throw ValidationException::withMessages([
                'creneau_id' => 'Ce créneau est complet.',
            ]);
        }

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'creneau_id' => $creneau->id,
            'status' => 'confirmed',
        ]);

        return response()->json(
            $reservation->load('creneau.cours', 'creneau.espace', 'creneau.coach'),
            201
        );
    }

    /**
     * Annuler sa propre réservation.
     */
    public function destroy(Request $request, Reservation $reservation): JsonResponse
    {
        // On ne peut annuler que sa propre réservation.
        if ($reservation->user_id !== $request->user()->id) {
            abort(403, 'Accès réservé.');
        }

        $reservation->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Réservation annulée.']);
    }

    /**
     * Le QR code de sa propre réservation, en SVG.
     * Le membre l'affiche à l'écran, le coach le scanne pour valider sa présence.
     */
    public function qr(Request $request, Reservation $reservation): Response
    {
        // On ne montre que son propre code.
        if ($reservation->user_id !== $request->user()->id) {
            abort(403, 'Accès réservé.');
        }

        $writer = new Writer(new ImageRenderer(new RendererStyle(300, 1), new SvgImageBackEnd));

        return response($writer->writeString($reservation->qrToken()), 200, [
            'Content-Type' => 'image/svg+xml',
        ]);
    }
}
