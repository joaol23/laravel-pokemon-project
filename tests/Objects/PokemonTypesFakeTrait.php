<?php

namespace Tests\Objects;

use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Dto\Pokemon\PokemonTypeCreateDto;

trait PokemonTypesFakeTrait
{
    protected function pokemonListTypesCreateDto(): PokemonListTypesCreateDto
    {
        return (new PokemonListTypesCreateDto())->add($this->pokemonTypeCreateDto());
    }
    protected function pokemonTypeCreateDto(): PokemonTypeCreateDto
    {
        return new PokemonTypeCreateDto("eletric");
    }
}
