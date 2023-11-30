<?php

namespace App\Clients\Pokemon\PokeApi\V2;

use App\Clients\Pokemon\PokeApi\Interfaces\ApiServiceInterface;
use App\Clients\Pokemon\PokeApi\V2\Traits\HasPokemon;
use App\Clients\Pokemon\PokeApi\V2\Traits\HasPokemons;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ApiServiceV2 implements ApiServiceInterface
{
    use HasPokemons, HasPokemon;
    private const BASE_URL = "https://pokeapi.co/api/v2/";

    public function api(): PendingRequest
    {
        return Http::baseUrl(
            self::BASE_URL
        );
    }
}
