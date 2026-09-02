<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cours extends Model
{
    // "Cours" est invariable : on fixe la table pour éviter "courses".
    protected $table = 'cours';

    protected $fillable = [
        'name',
        'sport_type',
        'description',
        'espace_id',
        'coach_id',
        'max_participants',
        'status',
    ];

    /**
     * L'espace (emplacement) où se déroule le cours.
     */
    public function espace(): BelongsTo
    {
        return $this->belongsTo(Espace::class);
    }

    /**
     * Le coach responsable du cours (un utilisateur de rôle coach).
     */
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
