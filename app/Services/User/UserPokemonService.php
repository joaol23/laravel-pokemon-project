<?php

namespace App\Services\User;

use App\Contracts\Repository\UserPokemonRepositoryContract;
use App\Contracts\Repository\UserRepositoryContract;
use App\Contracts\Services\UserPokemonServiceContract;
use App\Dto\UserPokemon\AddPokemonUserDto;
use App\Enum\LogsFolder;
use App\Models\User;
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

    public function addPokemon(
        AddPokemonUserDto $addPokemonUserDto
    ): bool {
        try {
            if ($this->existsOfOrder(
                $addPokemonUserDto->userId,
                $addPokemonUserDto->order
            )) {
                $this->userPokemonRepository->updatePokemon($addPokemonUserDto);
                return true;
            }

            return $this->userPokemonRepository->addPokemon($addPokemonUserDto);
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Error ao selecionar pokemon => " . $e->getMessage(),
                LogsFolder::USERS
            );
            throw new \RuntimeException(
                "Error ao selecionar pokemon!",
                $e instanceof QueryException
                    ? Response::HTTP_BAD_REQUEST
                    : Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function existsOfOrder(
        int $userId,
        int $order
    ): bool {
        return $this->userPokemonRepository->existsOfOrder(
            $userId,
            $order
        );
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

    public function removePokemonInOrder(
        int $userId,
        int $order
    ): bool {
        try {
            /** @var User $user */
            $user = $this->userRepository::find($userId);
            return $this->userPokemonRepository->removePokemonByOrder(
                $user, $order
            );
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Error ao excluir pokemon na posição {$order} => " . $e->getMessage(),
                LogsFolder::USERS
            );
            throw new \RuntimeException("Error ao excluir pokemom!");
        }
    }
}
