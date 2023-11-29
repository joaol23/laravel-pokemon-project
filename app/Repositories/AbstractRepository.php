<?php

namespace App\Repositories;

use App\Exceptions\ObjectNotFound;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    protected static Model|string $model = '';

    protected static function exists(
        int $id
    ): void {
        if (!(static::loadModel()
            ->query()
            ->where('id', $id)->exists())) {
            throw new ObjectNotFound('Usuário');
        }
    }

    protected static function loadModel(): Model
    {
        if (!(self::$model instanceof Model)) {
            self::$model = app(static::$model);
        }
        return self::$model;
    }
}
