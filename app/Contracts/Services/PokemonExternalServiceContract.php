<?php

namespace App\Contracts\Services;

use App\Clients\Pokemon\PokeApi\V2\Entities\ResourceListEntity;
use App\Clients\Pokemon\PokeApi\V2\Entities\Unit\PokemonEntity;

interface PokemonExternalServiceContract
{
    public function getPokemon(string $name): PokemonEntity;

    public function getPokemons(int $page, int $limit): ResourceListEntity;
}
