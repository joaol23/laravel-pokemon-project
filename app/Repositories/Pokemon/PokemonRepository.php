<?php

namespace App\Repositories\Pokemon;

use App\Contracts\Repository\PokemonRepositoryContract;
use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Models\Pokemon\Pokemon;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Model;

class PokemonRepository extends CrudRepository implements PokemonRepositoryContract
{
    protected static Model|string $model = Pokemon::class;

    public function setTypes(
        PokemonListTypesCreateDto $pokemonTypesCreateDto,
        Pokemon $pokemon
    ): bool {
        //todo
    }
}
