<?php

namespace App\Repositories\User;

use App\Contracts\Repository\UserPokemonRepositoryContract;
use App\Models\User;
use App\Repositories\AbstractRepository;

class UserPokemonRepository extends AbstractRepository implements UserPokemonRepositoryContract
{
    protected static string $model = User::class;

    public function addPokemon(int $userId, int $pokemonId): array
    {
        return self::loadModel()
            ->query()
            ->findOrFail($userId)
            ->pokemons()
            ->syncWithoutDetaching($pokemonId);
    }
}
