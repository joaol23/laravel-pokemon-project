<?php

namespace App\Clients\Pokemon\PokeApi\V2\Endpoints\Requests;

use App\Clients\Pokemon\PokeApi\V2\Endpoints\BaseGetRequest;
use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityInterface;
use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityListInterface;
use App\Clients\Pokemon\PokeApi\V2\Entities\Unit\PokemonEntity;
use App\Exceptions\Clients\Requests\ParameterNotSet;

class Pokemon extends BaseGetRequest
{
    private string $pokemon;

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
