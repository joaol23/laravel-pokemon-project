<?php

namespace App\Repositories\Pokemon;

use App\Contracts\Repository\PokemonRepositoryContract;
use App\Models\Pokemon\Pokemon;
use App\Models\User;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class PokemonRepository extends AbstractRepository implements PokemonRepositoryContract
{
    protected static Model|string $model = Pokemon::class;
    public function setTypes(): bool
    {
        // TODO: Implement setTypes() method.
    }
}
