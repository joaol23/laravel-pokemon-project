<?php

namespace App\Repositories\User;

use App\Contracts\Repository\UserRepositoryContract;
use App\Models\User;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends AbstractRepository implements UserRepositoryContract
{
    protected static Model|string $model = User::class;

    public function getByEmail(string $email): User
    {
        /** @var User */
        return $this->loadModel()
            ->query()
            ->where('email', $email)
            ->firstOrFail();
    }
}
