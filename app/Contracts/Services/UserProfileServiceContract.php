<?php

namespace App\Contracts\Services;
use App\Dto\User\UserProfileSaveImageInterface;

interface UserProfileServiceContract
{
    public function savePhoto(
        UserProfileSaveImageInterface $userProfileSaveImageDto
    ): bool;
}
