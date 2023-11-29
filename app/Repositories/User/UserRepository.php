<?php

namespace App\Repositories\User;

use App\Contracts\Repository\UserRepositoryContract;
use App\Models\User;
use App\Repositories\AbstractRepository;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends CrudRepository implements UserRepositoryContract
{
    protected static Model|string $model = User::class;

    public function getByEmail(string $email): User
    {
        /** @var User */
        return self::loadModel()
            ->query()
            ->where('email', $email)
            ->firstOrFail();
    }
}
