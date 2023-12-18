<?php

namespace App\Dto\UserPokemon;

use App\Dto\BaseDto;

class AddPokemonUserDto extends BaseDto
{
    public function __construct(
        public int $order,
        public int $userId,
        public int $pokemonId
    ) {
    }
}
