<?php

namespace App\Repositories;

use App\Exceptions\ObjectNotFound;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    protected static string $model = '';

    protected static function exists(
        int $id
    ): void {
        if (!(static::loadModel()
            ->query()
            ->where('id', $id)->exists())) {
            throw new ObjectNotFound();
        }
    }

    protected static function loadModel(): Model
    {
        return app(static::$model);
    }
}
