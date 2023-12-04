<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities\Unit;

class StatsEntity
{
    public string $name;

    public int $base_stat;

    public function __construct(array $data)
    {
        $this->name = data_get($data, 'stat.name');
        $this->base_stat = data_get($data, 'base_stat');
    }

}
