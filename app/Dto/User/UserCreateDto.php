<?php

namespace App\Dto\User;

use App\Dto\BaseDto;
use Illuminate\Support\Facades\Hash;

class UserCreateDto extends BaseDto
{
    public function __construct(
        public string $name,
        public string $email,
        private readonly string $password
    ) {
    }

    private function getPublicPassword(): string
    {
        return Hash::make($this->password);
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        return array_merge(
            $array,
            [
                "password" => $this->getPublicPassword()
            ]
        );
    }
}
