<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends AbstractRepository
{
    protected static Model|string $model = User::class;
}
