<?php

namespace App\Contracts\Repository;

use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Models\Pokemon\Pokemon;
use App\Models\Pokemon\PokemonTypes;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PokemonRepositoryContract extends RepositoryContract
{

    /**
     * @param Pokemon $pokemon
     * @param PokemonTypes[] $types
     * @return bool
     */
    public function setTypes(
        Pokemon $pokemon,
        array $types
    ): void;

    public function existsByName(
        string $name
    ): bool;

    public function searchByName(
        string $name
    ): LengthAwarePaginator;
}
