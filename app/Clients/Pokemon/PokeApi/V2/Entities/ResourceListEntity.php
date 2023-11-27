<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities;

use App\Clients\Pokemon\PokeApi\Interfaces\EntityInterface;
use App\Clients\Pokemon\PokeApi\V2\Entities\Lists\PokemonListEntity;
use Illuminate\Support\Collection;

readonly class ResourceListEntity implements EntityInterface
{
    public Collection $results;
    public int $count;
    public string $previous;
    public string $next;

    public function __construct(
        array $data,
        string $entityClass
    )
    {
        $this->count = data_get($data, 'count');
        $this->next = data_get($data, 'next');
        $this->previous = data_get($data, 'previous');
        $this->setResults(data_get($data, 'results'), $entityClass);
    }

    private function setResults(array $results, string $entityClass): void
    {
        $this->results = new Collection();
        foreach ($results as $result) {
            $entityResult = new $entityClass($result);
            $this->results->add($entityResult);
        }
    }
}
