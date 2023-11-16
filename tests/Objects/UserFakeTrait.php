<?php

namespace Tests\Objects;

trait UserFakeTrait
{
    protected function getFakeUser(?string $email = null, ?string $password = null)
    {
        return [
            "name" => "John Smith",
            "email" => $email ?? "john@smith.com",
            "password" => $password ?? "12345678",
            "password_confirmation" => "12345678"
        ];
    }
}
