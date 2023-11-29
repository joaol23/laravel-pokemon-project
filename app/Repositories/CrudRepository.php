<?php

namespace App\Repositories;

use App\Contracts\Repository\RepositoryContract;
use App\Exceptions\ObjectNotFound;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class CrudRepository extends AbstractRepository implements RepositoryContract
{
    public static function all(): Collection
    {
        return static::loadModel()->all();
    }

    public static function create(array $data): Model
    {
        return static::loadModel()
            ->query()
            ->create($data);
    }

    public static function find(int $id): Model
    {
        self::exists($id);
        return static::loadModel()
            ->query()
            ->find($id);
    }

    public static function update(
        array $data,
        int   $id
    ): int {
        self::exists($id);
        return static::loadModel()->query()
            ->where(static::loadModel()->getKeyName(), $id)
            ->update($data);
    }

    public static function delete(int $id): bool
    {
        self::exists($id);
        return static::loadModel()->query()
            ->where(static::loadModel()->getKeyName(), $id)
            ->delete();
    }
}
