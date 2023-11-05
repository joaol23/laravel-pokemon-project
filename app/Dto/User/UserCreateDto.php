<?php

namespace App\Dto\User;

use Illuminate\Support\Facades\Hash;

class UserCreateDto
{
    public function __construct(
        public string $name,
        public string $email,
        private string $password
    ) {
    }

    public function getPublicPassword(): string
    {
        return Hash::make($this->password);
    }
}
