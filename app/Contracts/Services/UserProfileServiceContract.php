<?php

namespace App\Contracts\Services;
use App\Dto\User\UserProfileSaveImageDto;

interface UserProfileServiceContract
{
    public function savePhoto(
        UserProfileSaveImageDto $userProfileSaveImageDto
    ): bool|string;
}
