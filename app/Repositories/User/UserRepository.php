<?php

namespace App\Repositories\User;

use App\Contracts\Repository\UserRepositoryContract;
use App\Models\User;
use App\Repositories\CrudRepository;
class UserRepository extends CrudRepository implements UserRepositoryContract
{
    protected static string $model = User::class;

    public function getByEmail(string $email): User
    {
        /** @var User */
        return self::loadModel()
            ->query()
            ->where('email', $email)
            ->firstOrFail();
    }
}
