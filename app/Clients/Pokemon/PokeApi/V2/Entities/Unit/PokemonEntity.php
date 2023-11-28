<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities\Unit;

use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityInterface;

class PokemonEntity implements EntityInterface
{
    private const IMAGE_URL_DEFAUL = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/";

    public string $name;

    public int $id;

    public array $types;

    public string $imageUrl;

    public function __construct(array $data)
    {
        $this->name = data_get($data, 'name');
        $this->id = data_get($data, 'id');
        $this->types = $this->getTypes(data_get($data, 'types'));
        $this->imageUrl = $this->imageUrl();
    }

    private function getTypes(array $types): array
    {
        return array_map(fn($type) => $type['type']['name'], $types);
    }

    /**
     * @return string
     */
    private function imageUrl(): string
    {
        return self::IMAGE_URL_DEFAUL . "{$this->id}.png";
    }
}
