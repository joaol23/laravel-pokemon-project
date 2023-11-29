<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pokemons_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pokemon_id");
            $table->unsignedBigInteger("type_pokemon_id");

            $table->foreign('pokemon_id')->references("id")
                ->on('pokemon')->onDelete('cascade');

            $table->foreign('type_pokemon_id')->references("id")
                ->on('pokemonTypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemons_types');
    }
};
