<?php

namespace App\Contracts\Repository;

use App\Dto\Pokemon\PokemonTypeCreateDto;
use App\Models\Pokemon\PokemonTypes;
use Illuminate\Database\Eloquent\Collection;

interface PokemonTypesRepositoryContract extends RepositoryContract
{
    public function getByName(
        string $name
    ): ?PokemonTypes;
}
