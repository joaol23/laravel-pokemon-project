<?php

namespace App\Clients\Pokemon\PokeApi\Interfaces;

interface PaginationRequestInterface
{
    public function limit(int $limit): static;
    public function page(int $page): static;

    public function getLimit(): int;
    public function getOffset():int;
}
