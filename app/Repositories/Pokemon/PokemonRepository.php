<?php

namespace App\Repositories\Pokemon;

use App\Contracts\Repository\PokemonRepositoryContract;
use App\Models\Pokemon\Pokemon;
use App\Repositories\CrudRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class PokemonRepository extends CrudRepository implements PokemonRepositoryContract
{
    protected static string $model = Pokemon::class;
    protected static int $paginate = 30;

    public static function all(): LengthAwarePaginator
    {
        $currentPage = Paginator::resolveCurrentPage('page');
        return Cache::remember(
            "pokemons_list_{$currentPage}",
            now()->addMinutes(10),
            fn() => static::loadModel()::query()
                ->orderBy('pokemon_id')
                ->paginate(static::$paginate)
        );
    }

    public function setTypes(
        Pokemon $pokemon,
        array $types
    ): void {
        $pokemon->types()
            ->attach(array_column($types, "id"));
    }

    public function existsByName(
        string $name
    ): bool {
        return self::loadModel()
            ->query()
            ->where('name', $name)
            ->exists();
    }
}
