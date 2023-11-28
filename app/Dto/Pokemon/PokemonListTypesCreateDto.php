<?php

namespace App\Dto\Pokemon;

class PokemonListTypesCreateDto
{
    /* @var PokemonTypeCreateDto[] */
    public array $types;

    public function addType(PokemonTypeCreateDto $type): void
    {
        $this->types[] = $type;
    }
}
