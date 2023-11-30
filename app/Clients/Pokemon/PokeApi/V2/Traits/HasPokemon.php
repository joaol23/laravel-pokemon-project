<?php

namespace App\Clients\Pokemon\PokeApi\V2\Traits;

use App\Clients\Pokemon\PokeApi\V2\Endpoints\Requests\Pokemon;

trait HasPokemon
{
    public function pokemon(): Pokemon
    {
        return new Pokemon($this);
    }
}
