<?php

namespace App\Services\User;

use App\Contracts\Repository\UserPokemonRepositoryContract;
use App\Contracts\Repository\UserRepositoryContract;
use App\Contracts\Services\UserPokemonServiceContract;
use App\Enum\LogsFolder;
use App\Utils\Logging\CustomLogger;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class UserPokemonService implements UserPokemonServiceContract
{
    public function __construct(
        private readonly UserPokemonRepositoryContract $userPokemonRepository,
        private readonly UserRepositoryContract $userRepository
    ) {
    }

    public function addPokemon(int $userId, int $pokemonId): bool
    {
        try {
            $this->userPokemonRepository->addPokemon($userId, $pokemonId);
            return true;
        } catch (QueryException $e) {
            CustomLogger::error(
                "Error ao adicionar pokemon => " . $e->getMessage(),
                LogsFolder::USERS
            );
            throw new \RuntimeException("Error ao selecionar pokemon!", Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Error ao selecionar pokemon => " . $e->getMessage(),
                LogsFolder::USERS
            );
            throw new \RuntimeException("Error ao selecionar pokemon!");
        }
    }

    public function listPokemons(int $userId): Collection
    {
        try {
            return $this->userRepository::find($userId)
                ->pokemons()
                ->get();
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Error ao listar pokemons => " . $e->getMessage(),
                LogsFolder::USERS
            );
            throw new \RuntimeException("Error ao listar pokemons!");
        }
    }
}
