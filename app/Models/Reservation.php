<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'creneau_id', 'status'];

    /**
     * Le membre qui a réservé.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Le créneau réservé.
     */
    public function creneau(): BelongsTo
    {
        return $this->belongsTo(Creneau::class);
    }

    /**
     * Le contenu du QR code : l'identifiant de la réservation, suivi d'une
     * signature produite avec la clé de l'application. Le code est affiché à
     * l'écran, donc photographiable : sans la clé, il est impossible d'en
     * fabriquer un pour une autre réservation.
     */
    public function qrToken(): string
    {
        return $this->id.'.'.hash_hmac('sha256', (string) $this->id, config('app.key'));
    }

    /**
     * La réservation correspondant à un jeton, ou null si la signature est
     * invalide (jeton falsifié, tronqué ou réservation supprimée).
     */
    public static function findByToken(string $token): ?self
    {
        $reservation = static::find(strtok($token, '.'));

        // hash_equals : comparaison à temps constant, comme pour un mot de passe.
        if (! $reservation || ! hash_equals($reservation->qrToken(), $token)) {
            return null;
        }

        return $reservation;
    }
}
