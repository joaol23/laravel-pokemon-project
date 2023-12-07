<?php

namespace App\Contracts\Services;

use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Models\Pokemon\PokemonTypes;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PokemonTypesServiceContract
{

    /**
     * @return PokemonTypes[]
     */
    public function create(
        PokemonListTypesCreateDto $pokemonListTypesCreateDto
    ): array;

    public function listAll(): LengthAwarePaginator;

    public function getByName(string $name): ?PokemonTypes;
}
