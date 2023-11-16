<?php

namespace App\Contracts\Services;

use App\Dto\Auth\LoginDto;
use App\Models\User;

interface AuthServiceContract
{
    public function checkCredentials(LoginDto $loginDto): User;
    public function generateToken(User $user): string;
    public function deleteAllTokens(User $user): bool;
}