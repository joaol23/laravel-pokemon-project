<?php

namespace App\Services\Auth;

use App\Contracts\Repository\UserRepositoryContract;
use App\Contracts\Services\AuthServiceContract;
use App\Dto\Auth\LoginDto;
use App\Enum\LogsFolder;
use App\Exceptions\InternalError;
use App\Models\User;
use App\Utils\Logging\CustomLogger;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthService implements AuthServiceContract
{
    public function __construct(
        private readonly UserRepositoryContract $userRepository
    ) {
    }
    public function checkCredentials(LoginDto $loginDto): User
    {
        try {
            $user = $this->userRepository->getByEmail($loginDto->email);
            if (!Hash::check($loginDto->password, $user->password)) {
                throw new AuthenticationException();
            }

            return $user;
        } catch (ModelNotFoundException | AuthenticationException $e) {
            throw new AuthenticationException();
        } catch (\Exception $e) {
            CustomLogger::error(
                "Error => " . $e->getMessage() . "\n"
                    . "Informações usuario: " . print_r($loginDto->toArray(), true),
                LogsFolder::AUTH
            );
            throw new InternalError("Não foi possível realizar o login no momento!");
        }
    }

    public function generateToken(User $user): string
    {
        try {
            $this->deleteAllTokens($user);
            return $user->createToken(Str::random())
                ->plainTextToken;
        } catch (\Exception $e) {
            CustomLogger::error(
                "Error => ". $e->getMessage(). "\n"
                   . "Informações usuario: ". print_r($user, true),
                LogsFolder::AUTH
            );
            throw new InternalError("Token de acesso não pode ser gerado no momento!");
        }
    }

    public function deleteAllTokens(User $user): bool
    {
        return $user->tokens()->delete();
    }
}
