<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('creneaux', function (Blueprint $table) {
            $table->foreignId('espace_id')->nullable()->after('cours_id')->constrained('espaces');
            $table->foreignId('coach_id')->nullable()->after('espace_id')->constrained('users');
        });

        // Créneaux existants : on reprend l'espace et le coach de leur cours.
        foreach (DB::table('creneaux')->get() as $creneau) {
            $cours = DB::table('cours')->find($creneau->cours_id);

            if ($cours) {
                DB::table('creneaux')->where('id', $creneau->id)->update([
                    'espace_id' => $cours->espace_id,
                    'coach_id' => $cours->coach_id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creneaux', function (Blueprint $table) {
            $table->dropConstrainedForeignId('espace_id');
            $table->dropConstrainedForeignId('coach_id');
        });
    }
};
