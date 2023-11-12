<?php

namespace App\Repositories;

use App\Contracts\RepositoryContract;
use App\Exceptions\ObjectNotFound;
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
        self::exists($id);
        return static::loadModel()->find($id);
    }
    public static function update(
        array $data,
        int $id
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

    protected static function loadModel(): Model
    {
        return app(static::$model);
    }

    protected static function exists(
        int $id
    ): void {
        if (!(self::loadModel()::where('id', $id)->exists())) {
            throw new ObjectNotFound('Usuário');
        }
    }
}
