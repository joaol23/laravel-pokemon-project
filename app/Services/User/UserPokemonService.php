<?php

namespace App\Services\User;

use App\Contracts\Repository\UserPokemonRepositoryContract;
use App\Contracts\Services\UserPokemonServiceContract;
use App\Enum\LogsFolder;
use App\Utils\Logging\CustomLogger;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class UserPokemonService implements UserPokemonServiceContract
{
    public function __construct(
        private readonly UserPokemonRepositoryContract $userPokemonRepository
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
}
