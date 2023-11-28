<?php

namespace App\Dto\Pokemon;

use App\Dto\BaseDto;

class PokemonCreateDto extends BaseDto
{
    public function __construct(
        public int $pokemonId,
        public string $name,
        public string $imageUrl
    ) {
    }
}
