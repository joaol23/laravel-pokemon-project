<?php

namespace App\Clients\Pokemon\PokeApi\Facade;

use App\Clients\Pokemon\PokeApi\V2\ApiServiceV2;
use App\Clients\Pokemon\PokeApi\V2\Endpoints\Requests\Pokemons;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Pokemons pokemons()
 * */
class PokeApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ApiServiceV2::class;
    }
}
