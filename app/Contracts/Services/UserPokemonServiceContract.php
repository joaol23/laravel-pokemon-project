<?php

namespace App\Contracts\Services;

use App\Models\User;

interface UserPokemonServiceContract
{
    public function addPokemon(int $userId, int $pokemonId): bool;
}
