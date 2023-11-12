<?php

namespace App\Dto\User;
use App\Dto\BaseDto;

class UserUpdateDto extends BaseDto
{
    public function __construct(
        public string $name,
        public string $email
    ) {
    }
}
