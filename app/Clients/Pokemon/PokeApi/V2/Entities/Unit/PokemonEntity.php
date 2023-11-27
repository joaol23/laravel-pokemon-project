<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities\Unit;

use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityInterface;

class PokemonEntity implements EntityInterface
{
    public string $name;

    public int $id;

    public array $types;

    public string $imageUrl;

    public function __construct(array $data)
    {
        $this->name = data_get($data, 'name');
        $this->id = data_get($data, 'id');
        $this->types = $this->getTypes(data_get($data, 'types'));
        $this->imageUrl = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$this->id}.png";
    }

    private function getTypes(array $types): array
    {
        return array_map(fn($type) => $type['type']['name'], $types);
    }



}
