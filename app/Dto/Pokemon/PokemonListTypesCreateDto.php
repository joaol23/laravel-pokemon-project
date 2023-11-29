<?php

namespace App\Dto\Pokemon;

class PokemonListTypesCreateDto
{
    /* @var PokemonTypeCreateDto[] */
    public array $types;

    public function add(PokemonTypeCreateDto $type): void
    {
        $this->types[] = $type;
    }
}
