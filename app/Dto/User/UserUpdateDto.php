<?php

namespace App\Dto\User;

class UserUpdateDto
{
    public function __construct(
        public string $name,
        public string $email
    ) {
    }
}
