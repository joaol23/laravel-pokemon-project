<?php

namespace App\Services\Pokemon;

use App\Contracts\Repository\PokemonTypesRepositoryContract;
use App\Contracts\Services\PokemonTypesServiceContract;
use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Enum\LogsFolder;
use App\Models\Pokemon\PokemonTypes;
use App\Utils\Logging\CustomLogger;
use DomainException;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PokemonTypesService implements PokemonTypesServiceContract
{
    public function __construct(
        private readonly PokemonTypesRepositoryContract $pokemonTypesRepository
    ) {
    }


    /* @return PokemonTypes[] */
    public function create(
        PokemonListTypesCreateDto $pokemonListTypesCreateDto
    ): array {
        try {
            $types = [];
            foreach ($pokemonListTypesCreateDto->types as $type) {
                $pokemonType = $this->getByName($type->name);
                if ($pokemonType) {
                    $types[] = $pokemonType;
                    continue;
                }
                $types[] = $this->pokemonTypesRepository::create(
                    $type->toArray()
                );
            }
            return $types;
        } catch (Throwable $e) {
            CustomLogger::error(
                "Erro criação de tipos para pokemons => " . $e->getMessage()
                . "\n Tipos => " . print_r($pokemonListTypesCreateDto->types, true),
                LogsFolder::POKEMON_TYPES
            );
            throw new DomainException(
                "Erro criação de tipos para pokemons",
                Response::HTTP_BAD_REQUEST
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
