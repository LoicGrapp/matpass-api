<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ex. "HIIT Intense"
            $table->string('sport_type'); // type de sport
            $table->text('description')->nullable();
            $table->foreignId('espace_id')->constrained('espaces'); // l'emplacement
            $table->foreignId('coach_id')->constrained('users'); // le coach responsable
            $table->unsignedSmallInteger('max_participants')->default(10);
            $table->string('status')->default('active'); // active / cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
