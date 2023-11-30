<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities\Lists;

use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityInterface;
use App\Clients\Pokemon\PokeApi\V2\Entities\Unit\PokemonEntity;
use Illuminate\Support\Facades\Http;

readonly class PokemonListEntity implements EntityInterface
{
    public string $name;

    public string $url;

    public function __construct(array $data)
    {
        $this->name = data_get($data, 'name');
        $this->url = data_get($data, 'url');
    }

    public function details(): PokemonEntity {
        return new PokemonEntity(Http::get($this->url)->json());
    }
}
