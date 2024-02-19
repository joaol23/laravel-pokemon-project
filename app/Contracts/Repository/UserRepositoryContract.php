<?php

namespace App\Contracts\Repository;

use App\Models\User;

interface UserRepositoryContract extends RepositoryContract
{
    public function getByEmail(
        string $email
    ): User;

    public function savePhoto(
        string $url,
        int $idUser
    ): bool;
}
