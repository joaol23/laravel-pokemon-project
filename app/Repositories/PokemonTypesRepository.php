<?php

namespace App\Repositories;

use App\Contracts\Repository\PokemonTypesRepositoryContract;
use App\Models\Pokemon\PokemonTypes;

class PokemonTypesRepository extends CrudRepository implements PokemonTypesRepositoryContract
{
    public function getByName(string $name): ?PokemonTypes
    {
        /** @var PokemonTypes */
        return self::loadModel()
            ->query()
            ->where('name', $name)
            ->first();
    }
}
