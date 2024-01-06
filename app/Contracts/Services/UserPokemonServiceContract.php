<?php

namespace App\Contracts\Services;

use App\Dto\UserPokemon\AddPokemonUserDto;
use Illuminate\Database\Eloquent\Collection;

interface UserPokemonServiceContract
{
    public function addPokemon(
        AddPokemonUserDto $addPokemonUserDto
    ): bool;

    public function listPokemons(
        int $userId
    ): Collection;

    public function removePokemonInOrder(
        int $userId,
        int $order
    ): bool;
}
