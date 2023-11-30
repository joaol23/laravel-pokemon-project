<?php

namespace App\Services\Pokemon;

use App\Clients\Pokemon\PokeApi\Facade\PokeApi;
use App\Clients\Pokemon\PokeApi\V2\Entities\Lists\PokemonListEntity;
use App\Clients\Pokemon\PokeApi\V2\Entities\Unit\PokemonEntity;
use App\Contracts\Services\PokemonMigrateServiceContract;
use App\Contracts\Services\PokemonServiceContract;
use App\Dto\Pokemon\PokemonCreateDto;
use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Dto\Pokemon\PokemonTypeCreateDto;

class PokemonMigrateService implements PokemonMigrateServiceContract
{
    public function __construct(
        private readonly PokeApi                $pokeApi,
        private readonly PokemonServiceContract $pokemonService
    ) {
    }

    public function migrate(
        int $page,
        int $limit
    ): void {
        $pokemons = $this->pokeApi::pokemons()
            ->limit($limit)
            ->page($page)
            ->get();
        /* @var PokemonListEntity $pokemon */
        foreach ($pokemons->results() as $pokemon) {
            if ($this->pokemonService->existsByName($pokemon->name)) {
                continue;
            }

            $pokemonDetail = $pokemon->details();
            $pokemonCreateDto = new PokemonCreateDto(
                $pokemonDetail->id,
                $pokemonDetail->name,
                $pokemonDetail->imageUrl
            );

            $pokemonTypes = $this->getTypesPokemonDto($pokemonDetail);
            $this->pokemonService->create($pokemonCreateDto, $pokemonTypes);
        }
    }

    public function getTypesPokemonDto(
        PokemonEntity $pokemonDetail
    ): PokemonListTypesCreateDto {
        return array_reduce(
            $pokemonDetail->types,
            fn(PokemonListTypesCreateDto $carry, string $type) => $carry->add(
                new PokemonTypeCreateDto($type)
            ),
            new PokemonListTypesCreateDto()
        );
    }
}
