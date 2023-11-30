<?php

namespace App\Services\User;

use App\Contracts\Repository\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Dto\User\UserUpdateDto;
use App\Enum\LogsFolder;
use App\Exceptions\ObjectNotFound;
use App\Models\User;
use App\Notifications\UserCreatedNotification;
use App\Utils\Logging\CustomLogger;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class UserService implements UserServiceContract
{
    public function __construct(
        private readonly UserRepositoryContract $userRepository
    ) {
    }

    public function create(
        UserCreateDto $userCreateDto
    ): User {
        try {
            /** @var User $user */
            $user = $this->userRepository::create($userCreateDto->toArray());

            $user->notify(new UserCreatedNotification());
            return $user;
        } catch (\Exception $e) {
            CustomLogger::error(
                "Error => " . $e->getMessage() . "\n"
                . "Informações usuario: " . print_r($userCreateDto->toArray(), true),
                LogsFolder::USERS
            );
            throw new \DomainException("Erro ao inserir usuário!", Response::HTTP_BAD_REQUEST);
        }
    }

    public function listAll(): Collection
    {
        try {
            return $this->userRepository::all();
        } catch (\Exception $e) {
            CustomLogger::error(
                "Error => " . $e->getMessage(),
                LogsFolder::USERS
            );
            throw new \DomainException("Erro ao listar usuários!", Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(
        UserUpdateDto $userUpdateDto,
        int           $id
    ): User {
        try {
            $this->userRepository::update($userUpdateDto->toArray(), $id);
            return $this->getById($id);
        } catch (ObjectNotFound $e) {
            throw $e;
        } catch (\Exception $e) {
            CustomLogger::error(
                "Error => " . $e->getMessage() . "\n"
                . "Informações usuario: " . print_r($userUpdateDto->toArray(), true),
                LogsFolder::USERS
            );
            throw new \DomainException("Erro ao atualizar dados do usuário!", Response::HTTP_BAD_REQUEST);
        }
    }

    public function getById(int $id): User
    {
        try {
            /** @var User */
            return $this->userRepository::find($id);
        } catch (ObjectNotFound $e) {
            throw $e;
        } catch (\Exception $e) {
            CustomLogger::error(
                "Error => " . $e->getMessage(),
                LogsFolder::USERS
            );
            throw new ObjectNotFound('Usuário');
        }
    }

    public function inactive(int $id): bool
    {
        try {
            return $this->userRepository::delete($id);
        } catch (ObjectNotFound $e) {
            throw $e;
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Error => " . $e->getMessage() . "\n"
                . "Id: " . $id,
                LogsFolder::USERS
            );
            throw new \DomainException("Erro ao inativar usuário!", Response::HTTP_BAD_REQUEST);
        }
    }
}
