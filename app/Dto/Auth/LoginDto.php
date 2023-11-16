<?php

namespace App\Dto\Auth;

use App\Dto\BaseDto;

class LoginDto extends BaseDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }
}
