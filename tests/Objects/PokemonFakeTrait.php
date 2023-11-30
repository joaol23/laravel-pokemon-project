<?php

namespace Tests\Objects;

use App\Dto\Pokemon\PokemonCreateDto;

trait PokemonFakeTrait
{
    protected function pokemonCreateDto(): PokemonCreateDto
    {
        return new PokemonCreateDto(
            213,
            "Pikachu",
            "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png",
        );
    }

}
