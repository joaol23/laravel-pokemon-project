<?php

namespace App\Contracts\Services;

use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Models\Pokemon\PokemonTypes;
use Illuminate\Database\Eloquent\Collection;

interface PokemonTypesServiceContract
{

    /**
     * @return PokemonTypes[]
     */
    public function create(
        PokemonListTypesCreateDto $pokemonListTypesCreateDto
    ): array;

    public function listAll(): Collection;

    public function getByName(string $name): ?PokemonTypes;
}
