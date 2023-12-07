<?php

namespace App\Contracts\Services;

use App\Dto\User\UserCreateDto;
use App\Dto\User\UserUpdateDto;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceContract
{
    public function create(UserCreateDto $userCreateDto): User;
    public function listAll(): LengthAwarePaginator;
    public function getById(int $id): User;
    public function update(UserUpdateDto $userUpdateDto, int $id): User;

    public function inactive(int $id): bool;
}
