<?php

namespace App\Contracts;

use App\Dto\User\UserCreateDto;
use App\Dto\User\UserUpdateDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceContract
{
    public function create(UserCreateDto $userCreateDto): User;
    public function listAll(): Collection;
    public function getById(int $id): User;
    public function update(UserUpdateDto $userUpdateDto, int $id): User;

    public function inactive(int $id): bool;
}
