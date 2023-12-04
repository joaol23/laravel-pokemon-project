<?php

namespace App\Services\Pokemon;

use App\Clients\Pokemon\PokeApi\Facade\PokeApi;
use App\Clients\Pokemon\PokeApi\V2\Entities\ResourceListEntity;
use App\Clients\Pokemon\PokeApi\V2\Entities\Unit\PokemonEntity;
use App\Contracts\Services\PokemonExternalServiceContract;
use App\Enum\LogsFolder;
use App\Exceptions\ObjectNotFound;
use App\Utils\Logging\CustomLogger;

class PokemonExternalService implements PokemonExternalServiceContract
{
    public function __construct(
        private readonly PokeApi $pokeApi
    ) {
    }

    public function getPokemon(string $name): PokemonEntity
    {
        try {
            /** @var PokemonEntity */
            return $this->pokeApi::pokemon()
                ->namePokemon($name)
                ->get();
        } catch (\Throwable $e) {
            CustomLogger::notice(
                "Error => " . $e->getMessage(),
                LogsFolder::API_EXTERNAL_POKEMON);
            throw new ObjectNotFound("Pokemon");
        }
    }

    public function getPokemons(int $page, int $limit): ResourceListEntity
    {
        try {
            return $this->pokeApi::pokemons()
                ->limit($limit)
                ->page($page)
                ->get();
        } catch (\Throwable $e) {
            CustomLogger::notice(
                "Error => " . $e->getMessage(),
                LogsFolder::API_EXTERNAL_POKEMON);
            throw new ObjectNotFound("Pokemons");
        }
    }
}
