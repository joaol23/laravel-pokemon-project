<?php

namespace App\Services\Pokemon;

use App\Clients\Pokemon\PokeApi\Facade\PokeApi;
use App\Clients\Pokemon\PokeApi\V2\Entities\ResourceListEntity;
use App\Clients\Pokemon\PokeApi\V2\Entities\Unit\PokemonEntity;
use App\Contracts\Services\PokemonExternalServiceContract;

class PokemonExternalService implements PokemonExternalServiceContract
{
    public function __construct(
        private readonly PokeApi $pokeApi
    ) {
    }

    public function getPokemon(string $name): PokemonEntity
    {
        /** @var PokemonEntity */
        return $this->pokeApi::pokemon()
            ->namePokemon($name)
            ->get();
    }

    public function getPokemons(int $page, int $limit): ResourceListEntity
    {
        return $this->pokeApi::pokemons()
            ->limit($limit)
            ->page($page)
            ->get();
    }
}
