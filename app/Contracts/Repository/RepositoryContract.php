<?php

namespace App\Contracts\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryContract
{
    public static function create(
        array $data
    ): Model;
    public static function all(): Collection;
    public static function find(int $id): Model;
    public static function update(
        array $data,
        int $id
    ): int;

    public static function delete(int $id): bool;
}
