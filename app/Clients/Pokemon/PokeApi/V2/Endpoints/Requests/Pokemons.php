<?php

namespace App\Clients\Pokemon\PokeApi\V2\Endpoints\Requests;

use App\Clients\Pokemon\PokeApi\Interfaces\EntityInterface;
use App\Clients\Pokemon\PokeApi\Interfaces\EntityListInterface;
use App\Clients\Pokemon\PokeApi\V2\Endpoints\PaginateGetRequest;
use App\Clients\Pokemon\PokeApi\V2\Entities\Lists\PokemonListEntity;
use App\Clients\Pokemon\PokeApi\V2\Entities\ResourceListEntity;

class Pokemons extends PaginateGetRequest
{

    protected function uri(): string
    {
        return 'pokemon';
    }

    protected function entity(array $data): EntityInterface|EntityListInterface
    {
        return new ResourceListEntity(
            $data,
            PokemonListEntity::class
        );
    }
}
