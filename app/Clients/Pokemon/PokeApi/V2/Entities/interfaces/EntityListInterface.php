<?php

namespace App\Clients\Pokemon\PokeApi\V2\Entities\interfaces;

use App\Clients\Pokemon\PokeApi\V2\Entities\ResourceListEntity;
use Illuminate\Support\Collection;

interface EntityListInterface
{
    public function results(): Collection;
    public function nextRequest(): ?ResourceListEntity;
    public function previousRequest(): ?ResourceListEntity;
}
