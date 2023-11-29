<?php

namespace App\Contracts\Repository;

use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Models\Pokemon\Pokemon;

interface PokemonRepositoryContract extends RepositoryContract
{
    public function setTypes(
        Pokemon $pokemon
    ): bool;
}
