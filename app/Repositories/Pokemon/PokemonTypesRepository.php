<?php

namespace App\Repositories\Pokemon;

use App\Contracts\Repository\PokemonTypesRepositoryContract;
use App\Models\Pokemon\PokemonTypes;
use App\Repositories\CrudRepository;
class PokemonTypesRepository extends CrudRepository implements PokemonTypesRepositoryContract
{
    protected static string $model = PokemonTypes::class;

    public function getByName(string $name): ?PokemonTypes
    {
        /** @var PokemonTypes */
        return self::loadModel()
            ->query()
            ->where('name', $name)
            ->first();
    }
}
