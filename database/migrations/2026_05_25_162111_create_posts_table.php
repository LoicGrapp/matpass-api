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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('excerpt');
            $table->longText('body');
            $table->string('cover_image')->nullable();
            $table->string('author_name');
            $table->string('author_initials', 4);
            $table->string('author_role')->nullable();
            $table->text('author_bio')->nullable();
            $table->json('tags')->nullable();
            $table->unsignedTinyInteger('read_minutes')->default(5);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
