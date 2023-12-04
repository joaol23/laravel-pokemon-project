<?php

namespace App\Clients\Pokemon\PokeApi\V2\Endpoints\Requests;

use App\Clients\Pokemon\PokeApi\V2\Endpoints\BaseGetRequest;
use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityInterface;
use App\Clients\Pokemon\PokeApi\V2\Entities\Unit\PokemonEntity;
use App\Exceptions\Clients\Requests\ParameterNotSet;
use App\Exceptions\ObjectNotFound;
use Illuminate\Support\Facades\Cache;

class Pokemon extends BaseGetRequest
{
    private string $pokemon;

    public function get(): PokemonEntity
    {
        try {
            /** @var PokemonEntity */
            return Cache::rememberForever(
                "pokemon_{$this->pokemon}",
                fn() => parent::get()
            );
        } catch (\Throwable $e) {
            throw new ObjectNotFound('Pokemon');
        }
    }

    public function namePokemon(string $name): static
    {
        $this->pokemon = $name;
        return $this;
    }

    protected function uri(): string
    {
        if (empty($this->pokemon)) {
            throw new ParameterNotSet('nome_pokemon');
        }

        return "pokemon/{$this->pokemon}";
    }

    protected function entity(array $data): EntityInterface
    {
        return new PokemonEntity($data);
    }
}
