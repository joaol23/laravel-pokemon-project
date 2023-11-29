<?php

namespace App\Contracts\Services;

use App\Dto\Pokemon\PokemonTypeCreateDto;
use App\Models\Pokemon\PokemonTypes;
use Illuminate\Database\Eloquent\Collection;

interface PokemonTypesServiceContract
{
    public function create(
        PokemonTypeCreateDto $pokemonListTypesCreateDto
    ): PokemonTypes;

    public function listAll(): Collection;

    public function getByName(string $name): ?PokemonTypes;
}
