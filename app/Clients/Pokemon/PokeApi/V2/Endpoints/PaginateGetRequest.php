<?php

namespace App\Clients\Pokemon\PokeApi\V2\Endpoints;

use App\Clients\Pokemon\PokeApi\Interfaces\PaginationRequestInterface;

abstract class PaginateGetRequest extends BaseGetRequest implements PaginationRequestInterface
{
    protected int $offset = 0, $limit = 100;

    public function page(
        int $page
    ): static
    {
        $this->offset = $page === 1 ? 0 : --$page * $this->limit;
        return $this;
    }

    public function limit(
        int $limit
    ): static
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
