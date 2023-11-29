<?php

namespace App\Repositories\Pokemon;

use App\Contracts\Repository\PokemonRepositoryContract;
use App\Models\Pokemon\Pokemon;
use App\Repositories\CrudRepository;

class PokemonRepository extends CrudRepository implements PokemonRepositoryContract
{
    protected static string $model = Pokemon::class;

    public function setTypes(
        Pokemon $pokemon,
        array   $types
    ): void {
        $pokemon->types()
            ->attach(array_column($types, "id"));
    }
}
