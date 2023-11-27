<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities\interfaces;

use App\Clients\Pokemon\PokeApi\V2\Entities\ResourceListEntity;

interface EntityListInterface
{
    public function nextRequest(): ?ResourceListEntity;
    public function previousRequest(): ?ResourceListEntity;
}
