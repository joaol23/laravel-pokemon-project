<?php

namespace App\Services\Auth;

use App\Contracts\Repository\UserRepositoryContract;
use App\Contracts\Services\AuthServiceContract;
use App\Exceptions\InternalError;
use App\Models\User;
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
    public function checkCredentials(\App\Dto\Auth\LoginDto $loginDto): User
    {
        try {
            $user = $this->userRepository->getByEmail($loginDto->email);
            if (!$user || !Hash::check($loginDto->password, $user->password)) {
                throw new AuthenticationException();
            }

            return $user;
        } catch (ModelNotFoundException|AuthenticationException $e) {
            throw new AuthenticationException();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new InternalError("Não foi possível realizar o login no momento.");
        }
    }

    public function generateToken(User $user): string
    {
        $this->deleteAllTokens($user);
        return $user->createToken(Str::random())
            ->plainTextToken;
    }

    public function deleteAllTokens(User $user): bool
    {
        return $user->tokens()->delete();
    }
}
