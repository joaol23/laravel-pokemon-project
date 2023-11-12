<?php

namespace App\Repositories;

use App\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AbstractRepository implements RepositoryContract
{
    protected static $model;

    public static function all(): Collection
    {
        return static::loadModel()->all();
    }

    public static function create(array $data): Model
    {
        return static::loadModel()->create($data);
    }
    public static function find(int $id): Model
    {
        return static::loadModel()->find($id);
    }
    public static function update(array $data, int $id): int
    {
        return static::loadModel()->query()
            ->where(static::loadModel()->getKeyName, $id)
            ->update($data);
    }
    public static function delete(int $id): bool
    {
        return static::loadModel()->query()
            ->where(static::loadModel()->getKeyName, $id)
            ->delete();
    }

    protected static function loadModel(): Model
    {
        return app(static::$model);
    }
}
