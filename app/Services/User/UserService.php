<?php

namespace App\Services\User;

use App\Contracts\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Dto\User\UserUpdateDto;
use App\Exceptions\ObjectNotFound;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceContract
{
    public function create(
        UserCreateDto $userCreateDto
    ): User {
        try {
            $user = new User();
            $user->name = $userCreateDto->name;
            $user->email = $userCreateDto->email;
            $user->password = $userCreateDto->getPublicPassword();

            $user->save();

            return $user;
        } catch (\Exception $e) {
            throw new \DomainException("Erro ao inserir usuário!", 400);
        }
    }

    public function listAll(): Collection
    {
        try {
            return User::all();
        } catch (\Exception $e) {
            throw new \DomainException("Erro ao listar usuários!", 400);
        }
    }

    public function getById(int $id): User
    {
        try {
            $this->userExists($id);
            return User::find($id);
        } catch (ObjectNotFound $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ObjectNotFound('Usuário');
        }
    }

    public function update(
        UserUpdateDto $userUpdateDto,
        User $user
    ): User {
        try {
            $user->update([
                "name" => $userUpdateDto->name,
                "email" => $userUpdateDto->email
            ]);

            return $user;
        } catch (\Exception $e) {
            throw new \DomainException("Erro ao atualizar dados do usuário!", 400);
        }
    }

    public function inactive(int $id): bool
    {
        try {
            $this->userExists($id);
            return User::query()->where("id", $id)->delete();
        } catch (ObjectNotFound $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new \DomainException("Erro ao inativar usuário!", 400);
        }
    }

    private function userExists(int $id): void
    {
        if (!(User::where('id', $id)->exists())) {
            throw new ObjectNotFound('Usuário');
        }
    }
}
