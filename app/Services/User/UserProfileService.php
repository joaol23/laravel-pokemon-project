<?php

namespace App\Services\User;

use App\Contracts\Services\UploadFileServiceContract;
use App\Contracts\Services\UserProfileServiceContract;
use App\Dto\User\UserProfileSaveImageDto;

class UserProfileService implements UserProfileServiceContract
{
    public function __construct(
        private readonly UploadFileServiceContract $uploadFileService
    )
    {
    }

    public function savePhoto(
        UserProfileSaveImageDto $userProfileSaveImageDto
    ): bool|string {
        try {
             return $this->uploadFileService
                ->upload($userProfileSaveImageDto, 'profile');
        } catch (\Throwable $e) {
        }
    }
}
