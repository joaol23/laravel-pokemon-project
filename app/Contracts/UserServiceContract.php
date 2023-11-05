<?php

namespace App\Contracts;

use App\Dto\User\UserCreateDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceContract
{
    public function create(UserCreateDto $userCreateDto): User;
    public function listAll(): Collection;
    public function getById(int $id): User;
}
