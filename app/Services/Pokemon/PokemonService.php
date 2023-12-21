<?php

namespace App\Services\Pokemon;

use App\Contracts\Repository\PokemonRepositoryContract;
use App\Contracts\Services\PokemonServiceContract;
use App\Contracts\Services\PokemonTypesServiceContract;
use App\Dto\Pokemon\PokemonCreateDto;
use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Enum\LogsFolder;
use App\Exceptions\ObjectNotFound;
use App\Models\Pokemon\Pokemon;
use App\Utils\Logging\CustomLogger;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class PokemonService implements PokemonServiceContract
{
    public function __construct(
        private readonly PokemonRepositoryContract $pokemonRepository,
        private readonly PokemonTypesServiceContract $pokemonTypesService
    ) {
    }

    public function create(
        PokemonCreateDto $pokemonCreateDto,
        PokemonListTypesCreateDto $pokemonListTypesCreateDto
    ): Pokemon {
        try {
            /* @var Pokemon $pokemon */
            $pokemon = $this->pokemonRepository
                ::create($pokemonCreateDto);

            $pokemonTypes = $this->pokemonTypesService->create(
                $pokemonListTypesCreateDto
            );

            $this->pokemonRepository->setTypes($pokemon, $pokemonTypes);
            return $pokemon;
        } catch (\Throwable $exception) {
            CustomLogger::error(
                "Erro criação de pokemon => " . $exception->getMessage()
                . "\n Pokemon => " . print_r($pokemonCreateDto->toArray(), true),
                LogsFolder::POKEMON
            );
            throw new \DomainException(
                "Erro criação de pokemon",
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function listAll(): LengthAwarePaginator
    {
        try {
            return $this->pokemonRepository::all();
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Erro listagem de pokemon => " . $e->getMessage(),
                LogsFolder::POKEMON
            );
            throw new \DomainException(
                "Erro listagem de pokemon",
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function existsByName(string $name): bool
    {
        try {
            return $this->pokemonRepository
                ->existsByName($name);
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Erro ao buscar pokemon => " . $e->getMessage(),
                LogsFolder::POKEMON
            );
            throw new ObjectNotFound('Pokemon');
        }
    }

    public function search(
        string $searchParam
    ): LengthAwarePaginator {
        try {
            return $this->pokemonRepository
                ->searchByName($searchParam);
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Erro ao buscar pokemon => " . $e->getMessage(),
                LogsFolder::POKEMON
            );
            throw new ObjectNotFound('Pokemon');
        }
    }
}
