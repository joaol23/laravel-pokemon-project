<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities\Lists;

use App\Clients\Pokemon\PokeApi\V2\Entities\Unit\StatsEntity;

class StatsListEntity implements \IteratorAggregate
{

    /**
     * @var StatsEntity[]
     */
    public array $list;

    public function __construct(array $data)
    {
        $this->list = array_map(fn($stat) => new StatsEntity($stat), $data);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->list);
    }
}
