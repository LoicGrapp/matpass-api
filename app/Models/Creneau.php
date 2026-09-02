<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Creneau extends Model
{
    // Pluriel irrégulier : on fixe la table.
    protected $table = 'creneaux';

    protected $fillable = [
        'cours_id',
        'espace_id',
        'coach_id',
        'date',
        'start_time',
        'end_time',
        'places',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
        ];
    }

    /**
     * Le cours dont ce créneau est une séance datée.
     */
    public function cours(): BelongsTo
    {
        return $this->belongsTo(Cours::class);
    }

    /**
     * L'espace (salle) de cette séance précise.
     */
    public function espace(): BelongsTo
    {
        return $this->belongsTo(Espace::class);
    }

    /**
     * Le coach assigné à cette séance précise.
     */
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    /**
     * Les réservations faites sur ce créneau.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
