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
        Schema::create('pokemons_types_pokemon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pokemon_id");
            $table->unsignedBigInteger("pokemon_types_id");

            $table->foreign('pokemon_id')->references("id")
                ->on('pokemon')->onDelete('cascade');

            $table->foreign('pokemon_types_id')->references("id")
                ->on('pokemon_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemons_types_pokemon');
    }
};
