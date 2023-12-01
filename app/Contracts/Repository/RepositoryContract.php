<?php

namespace App\Contracts\Repository;

use App\Dto\BaseDtoInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryContract
{
    public static function create(
        BaseDtoInterface $dto
    ): Model;
    public static function all(): Collection;
    public static function find(int $id): Model;
    public static function update(
        BaseDtoInterface $dto,
        int $id
    ): int;

    public static function delete(int $id): bool;
}
