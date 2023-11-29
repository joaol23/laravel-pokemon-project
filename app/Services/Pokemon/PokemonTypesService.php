<?php

namespace App\Services\Pokemon;

use App\Contracts\Repository\PokemonTypesRepositoryContract;
use App\Contracts\Services\PokemonTypesServiceContract;
use App\Dto\Pokemon\PokemonTypeCreateDto;
use App\Enum\LogsFolder;
use App\Models\Pokemon\PokemonTypes;
use App\Utils\Logging\CustomLogger;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class PokemonTypesService implements PokemonTypesServiceContract
{
    public function __construct(
        private readonly PokemonTypesRepositoryContract $pokemonTypesRepository
    ) {
    }

    public function create(
        PokemonTypeCreateDto $pokemonTypesCreateDto
    ): PokemonTypes {
        try {
            $pokemonType = $this->getByName($pokemonTypesCreateDto->name);
            if ($pokemonType) {
                return $pokemonType;
            }
            /* @var PokemonTypes */
            return $this->pokemonTypesRepository::create(
                $pokemonTypesCreateDto->toArray()
            );
        } catch (Throwable $e) {
            CustomLogger::error(
                "Erro criação de tipos para pokemons => " . $e->getMessage()
                . "\n Tipos => " . print_r($pokemonTypesCreateDto->toArray(), true),
                LogsFolder::POKEMON_TYPES
            );
        }
    }

    public function getByName(string $name): ?PokemonTypes
    {
        try {
            return $this->pokemonTypesRepository->getByName($name);
        } catch (Throwable $e) {
            CustomLogger::error(
                "Erro na busca de tipo para pokemons => " . $e->getMessage(),
                LogsFolder::POKEMON_TYPES
            );
        }
    }

    public function listAll(): Collection
    {
        try {
            return $this->pokemonTypesRepository::all();
        } catch (Throwable $e) {
            CustomLogger::error(
                "Erro listagem de tipos para pokemons => " . $e->getMessage(),
                LogsFolder::POKEMON_TYPES
            );
        }
    }
}
