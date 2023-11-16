<?php

namespace App\Services\Auth;

use App\Contracts\AuthServiceContract;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService implements AuthServiceContract
{
    public function checkCredentials(\App\Dto\Auth\LoginDto $loginDto): User
    {
        $user = User::where('email', $loginDto->email)->first();
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
