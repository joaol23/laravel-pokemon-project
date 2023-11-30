<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities;

use App\Clients\Pokemon\PokeApi\V2\Entities\interfaces\EntityListInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

readonly class ResourceListEntity implements EntityListInterface
{
    private Collection $results;
    public int $count;
    public ?string $previous;
    public ?string $next;

    public function __construct(
        array                   $data,
        private readonly string $entityClass
    )
    {
        $this->count = data_get($data, 'count');
        $this->next = data_get($data, 'next');
        $this->previous = data_get($data, 'previous');
        $this->setResults(data_get($data, 'results'));
    }

    private function setResults(array $results): void
    {
        $this->results = new Collection();
        foreach ($results as $result) {
            $entityResult = new $this->entityClass($result);
            $this->results->add($entityResult);
        }
    }

    public function nextRequest(): ?ResourceListEntity
    {
        if (is_null($this->next)) {
            return null;
        }

        return new $this(
            Http::get($this->next)->json()
            , $this->entityClass
        );
    }

    public function previousRequest(): ?ResourceListEntity
    {
        if (is_null($this->previous)) {
            return null;
        }
        return new $this(
            Http::get($this->previous)->json()
            , $this->entityClass
        );
    }

    public function results(): Collection
    {
        return $this->results;
    }


}
