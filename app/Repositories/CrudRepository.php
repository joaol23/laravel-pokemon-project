<?php

namespace App\Repositories;

use App\Contracts\Repository\RepositoryContract;
use App\Dto\BaseDtoInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

abstract class CrudRepository extends AbstractRepository implements RepositoryContract
{
    /**
     * Number of items per page
     * @var int
     */
    protected static int $paginate = 20;
    public static function all(): LengthAwarePaginator
    {
        return static::loadModel()::query()
            ->paginate(static::$paginate);
    }

    public static function create(BaseDtoInterface $dto): Model
    {
        return static::loadModel()
            ->query()
            ->create($dto->toArray());
    }

    public static function find(int $id): Model
    {
        self::exists($id);
        return static::loadModel()
            ->query()
            ->find($id);
    }

    public static function update(
        BaseDtoInterface $dto,
        int $id
    ): int {
        self::exists($id);
        return static::loadModel()
            ->query()
            ->where(static::loadModel()
                ->getKeyName(), $id)
            ->update($dto->toArray());
    }

    public static function delete(int $id): bool
    {
        self::exists($id);
        return static::loadModel()
            ->query()
            ->where(static::loadModel()
                ->getKeyName(), $id)
            ->delete();
    }
}
