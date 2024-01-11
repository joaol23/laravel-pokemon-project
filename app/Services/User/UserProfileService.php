<?php

namespace App\Services\User;

use App\Contracts\Repository\UserRepositoryContract;
use App\Contracts\Services\UploadFileServiceContract;
use App\Contracts\Services\UserProfileServiceContract;
use App\Dto\User\UserProfileSaveImageDto;
use App\Enum\LogsFolder;
use App\Exceptions\ErroSavingImageUser;
use App\Utils\Logging\CustomLogger;

class UserProfileService implements UserProfileServiceContract
{
    public function __construct(
        private readonly UploadFileServiceContract $uploadFileService,
        private readonly UserRepositoryContract $userRepository
    ) {
    }

    public function savePhoto(
        UserProfileSaveImageDto $userProfileSaveImageDto
    ): bool|string {
        try {
            $pathPhoto = $this->uploadFileService
                ->upload($userProfileSaveImageDto, 'profile');
            if (!$this->userRepository->savePhoto($pathPhoto, $userProfileSaveImageDto->userId)) {
                throw new ErroSavingImageUser();
            }
            return $pathPhoto;
        } catch (\Throwable $e) {
            CustomLogger::error(
                "Erro ao salvar imagem de perfil => " . $e->getMessage(),
                LogsFolder::USERS
            );
            throw new \RuntimeException("Erro ao salvar imagem!");
        }
    }
}
