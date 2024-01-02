<?php

namespace App\Repositories\User;

use App\Contracts\Repository\UserPokemonRepositoryContract;
use App\Dto\UserPokemon\AddPokemonUserDto;
use App\Models\User;
use App\Repositories\AbstractRepository;

class UserPokemonRepository extends AbstractRepository implements UserPokemonRepositoryContract
{
    protected static string $model = User::class;

    public function addPokemon(
        AddPokemonUserDto $addPokemonUserDto
    ): bool {
        $attached = self::loadModel()
            ->query()
            ->findOrFail($addPokemonUserDto->userId)
            ->pokemons()
            ->attach(
                $addPokemonUserDto->pokemonId,
                [
                    'order' => $addPokemonUserDto->order
                ]
            );
        return is_null($attached);
    }

    public function existsOfOrder(
        int $userId,
        int $order
    ): bool {
        return self::loadModel()
            ->query()
            ->findOrFail($userId)
            ->pokemons()
            ->wherePivot(
                'order',
                $order
            )
            ->exists();
    }

    public function updatePokemon(
        AddPokemonUserDto $addPokemonUserDto
    ): array {
        return self::loadModel()
            ->query()
            ->findOrFail($addPokemonUserDto->userId)
            ->pokemons()
            ->wherePivot('order', $addPokemonUserDto->order)
            ->sync(
                [
                    $addPokemonUserDto->pokemonId => [
                        'order' => $addPokemonUserDto->order
                    ]
                ]
            );
    }

    public function removePokemonByOrder(
        User $user,
        int $order
    ): bool {
        return $user->pokemons()
            ->wherePivot('order', $order)
            ->detach();
    }
}
