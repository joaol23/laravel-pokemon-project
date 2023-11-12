<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository
{
    protected static $model = User::class;
}
