<?php

namespace App\Services\User;

use App\Contracts\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Exceptions\ObjectNotFound;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceContract
{
    public function create(
        UserCreateDto $userCreateDto
    ): User {
        $user = new User();
        $user->name = $userCreateDto->name;
        $user->email = $userCreateDto->email;
        $user->password = $userCreateDto->getPublicPassword();

        $user->save();

        return $user;
    }

    public function listAll(): Collection
    {
        return User::all();
    }

    public function getById(int $id): User
    {
        if (!(User::where('id', $id)->exists())) {
            throw new ObjectNotFound('Usuário');
        }
        return User::find($id);
    }
}
