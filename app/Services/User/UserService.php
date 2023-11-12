<?php

namespace App\Services\User;

use App\Contracts\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Dto\User\UserUpdateDto;
use App\Exceptions\ObjectNotFound;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceContract
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function create(
        UserCreateDto $userCreateDto
    ): User {
        try {
            /** @var User */
            $user = $this->userRepository->create($userCreateDto->toArray());
            return $user;
        } catch (\Exception $e) {
            throw new \DomainException("Erro ao inserir usuário!", 400);
        }
    }

    public function listAll(): Collection
    {
        try {
            return $this->userRepository->all();
        } catch (\Exception $e) {
            throw new \DomainException("Erro ao listar usuários!", 400);
        }
    }

    public function getById(int $id): User
    {
        try {
            /** @var User */
            $user = $this->userRepository->find($id);
            return $user;
        } catch (ObjectNotFound $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ObjectNotFound('Usuário');
        }
    }

    public function update(
        UserUpdateDto $userUpdateDto,
        int $id
    ): User {
        try {
            $this->userRepository->update($userUpdateDto->toArray(), $id);
            return $this->getById($id);
        } catch (ObjectNotFound $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \DomainException("Erro ao atualizar dados do usuário!", 400);
        }
    }

    public function inactive(int $id): bool
    {
        try {
            return $this->userRepository->delete($id);
        } catch (ObjectNotFound $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new \DomainException("Erro ao inativar usuário!", 400);
        }
    }
}
