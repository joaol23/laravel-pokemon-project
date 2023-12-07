<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities\Unit;

use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityInterface;
use App\Clients\Pokemon\PokeApi\V2\Entities\Lists\StatsListEntity;

class PokemonEntity implements EntityInterface
{
    public string $name;

    public int $id;

    public array $types;

    public string $imageUrl;

    public string $imageUrlShiny;

    public int $weight;

    public StatsListEntity $stats;

    public function __construct(array $data)
    {
        $this->name = data_get($data, 'name');
        $this->id = data_get($data, 'id');
        $this->types = $this->getTypes(data_get($data, 'types'));
        $this->imageUrl = data_get($data, 'sprites.front_default');
        $this->imageUrlShiny = data_get($data, 'sprites.front_shiny');
        $this->weight = data_get($data, 'weight');
        $this->stats = new StatsListEntity(data_get($data, 'stats'));
    }

    private function getTypes(array $types): array
    {
        return array_map(fn($type) => $type['type']['name'], $types);
    }
}
