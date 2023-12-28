<?php

namespace App\Contracts\Services;

use App\Dto\Pokemon\PokemonCreateDto;
use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Models\Pokemon\Pokemon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PokemonServiceContract
{
    public function create(
        PokemonCreateDto $pokemonCreateDto,
        PokemonListTypesCreateDto $pokemonListTypesCreateDto
    ): Pokemon;

    public function listAll(): LengthAwarePaginator;

    public function existsByName(string $name): bool;

    public function search(
        string $searchParam
    ): LengthAwarePaginator;
}
