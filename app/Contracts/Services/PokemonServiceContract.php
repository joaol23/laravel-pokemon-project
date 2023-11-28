<?php

namespace App\Contracts\Services;

use App\Dto\Pokemon\PokemonCreateDto;
use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Models\Pokemon\Pokemon;
use Illuminate\Database\Eloquent\Collection;

interface PokemonServiceContract
{
    public function create(
        PokemonCreateDto $pokemonCreateDto,
        PokemonListTypesCreateDto $pokemonListTypesCreateDto
    ): Pokemon;

    public function listAll(): Collection;

    public function getById(int $id): Pokemon;
}
