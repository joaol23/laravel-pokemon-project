<?php

namespace Tests\Objects;

use App\Models\User;

trait UserFakeTrait
{
    protected function getFakeUser(?string $email = null, ?string $password = null): array
    {
        return [
            "name" => "John Smith",
            "email" => $email ?? "john@smith.com",
            "password" => $password ?? "12345678",
            "password_confirmation" => "12345678"
        ];
    }

    protected function getFakeModelUser(): User
    {
        return new User([
            "name" => "John Smith",
            "email" => "johnsmith@teste.com",
            "password" => "12345678"
        ]);
    }
}
