<?php

namespace App\Contracts\Repository;

use App\Dto\UserPokemon\AddPokemonUserDto;

interface UserPokemonRepositoryContract
{
    public function addPokemon(
        AddPokemonUserDto $addPokemonUserDto
    ): bool;

    public function existsOfOrder(
        int $userId,
        int $order
    ): bool;

    public function updatePokemon(
        AddPokemonUserDto $addPokemonUserDto
    ): array;
}
