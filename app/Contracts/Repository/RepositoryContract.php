<?php

namespace App\Contracts\Repository;

use App\Dto\BaseDtoInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface RepositoryContract
{
    public static function create(
        BaseDtoInterface $dto
    ): Model;
    public static function all(): LengthAwarePaginator;
    public static function find(int $id): Model;
    public static function update(
        BaseDtoInterface $dto,
        int $id
    ): int;

    public static function delete(int $id): bool;
}
