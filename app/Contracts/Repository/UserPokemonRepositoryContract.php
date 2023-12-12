<?php

namespace App\Contracts\Repository;

interface UserPokemonRepositoryContract
{
    public function addPokemon(int $userId, int $pokemonId): array;
}
