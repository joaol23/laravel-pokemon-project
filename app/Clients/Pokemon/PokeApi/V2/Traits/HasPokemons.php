<?php

namespace App\Clients\Pokemon\PokeApi\V2\Traits;

use App\Clients\Pokemon\PokeApi\V2\Endpoints\Requests\Pokemons;

trait HasPokemons
{
    public function pokemons(): Pokemons
    {
        return new Pokemons($this);
    }
}
