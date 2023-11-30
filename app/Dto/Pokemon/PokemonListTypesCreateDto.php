<?php

namespace App\Dto\Pokemon;

class PokemonListTypesCreateDto
{
    /* @var PokemonTypeCreateDto[] */
    public array $types;

    public function add(PokemonTypeCreateDto $type): static
    {
        $this->types[] = $type;
        return $this;
    }
}
