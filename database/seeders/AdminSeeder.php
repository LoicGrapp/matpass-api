<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Crée (ou met à jour) le compte administrateur de départ.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'loic.hollay@gmail.com'],
            [
                'name' => 'Loïc Hollay',
                'password' => 'password', // haché automatiquement par le modèle User.
                'role' => 'admin',
                'status' => 'active',
            ],
        );
    }
}
