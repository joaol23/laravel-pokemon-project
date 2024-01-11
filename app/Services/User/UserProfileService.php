<?php

namespace App\Services\User;

use App\Contracts\Services\UploadFileServiceContract;
use App\Contracts\Services\UserProfileServiceContract;
use App\Dto\User\UserProfileSaveImageInterface;

class UserProfileService implements UserProfileServiceContract
{
    public function __construct(
        private readonly UploadFileServiceContract $uploadFileService
    )
    {
    }

    public function savePhoto(
        UserProfileSaveImageInterface $userProfileSaveImageDto
    ): bool {
        try {
            $pathImage = $this->uploadFileService->upload($userProfileSaveImageDto);
            return false;
        } catch (\Throwable $e) {
        }
    }
}
