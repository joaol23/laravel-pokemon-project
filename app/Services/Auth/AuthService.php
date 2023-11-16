<?php

namespace App\Services\Auth;

use App\Contracts\Repository\UserRepositoryContract;
use App\Contracts\Services\AuthServiceContract;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService implements AuthServiceContract
{
    public function __construct(
        private readonly UserRepositoryContract $userRepository
    ) {
    }
    public function checkCredentials(\App\Dto\Auth\LoginDto $loginDto): User
    {
        $user = $this->userRepository->getByEmail($loginDto->email);
        if (!$user || !Hash::check($loginDto->password, $user->password)) {
            throw new AuthenticationException();
        }

        return $user;
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
