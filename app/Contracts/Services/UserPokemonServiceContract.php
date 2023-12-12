<?php

namespace App\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;

interface UserPokemonServiceContract
{
    public function addPokemon(
        int $userId,
        int $pokemonId
    ): bool;

    public function listPokemons(
        int $userId
    ): Collection;
}
