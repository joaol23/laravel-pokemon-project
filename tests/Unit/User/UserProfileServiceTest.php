<?php

use App\Contracts\Services\UploadFileServiceContract;
use App\Dto\User\UserProfileSaveImageDto;
use App\Services\User\UserProfileService;
use Illuminate\Http\UploadedFile;
use Tests\Unit\Mocks\User\UserRepositoryMock;

describe("Testando o serviço de perfil do usuario", function () {
    test("Testando se passa por todos os métodos e retorna o caminho da imagem", function () {
        $userRepository = UserRepositoryMock::savePhotoMock(
            "teste",
            2,
            true
        );
        $uploadServiceMock = Mockery::mock(UploadFileServiceContract::class);
        $uploadServiceMock
            ->expects("upload")
            ->andReturn("teste");

        $uploadPhotoDto = new UserProfileSaveImageDto(Mockery::mock(UploadedFile::class), 2);

        $userProfileService = new UserProfileService($uploadServiceMock, $userRepository);
        $return = $userProfileService->savePhoto($uploadPhotoDto);
    });

    test("Testando quando da erro em salvar no banco tem q retornar false", function () {
        $userRepository = UserRepositoryMock::savePhotoMock(
            "teste",
            2,
            false
        );
        $uploadServiceMock = Mockery::mock(UploadFileServiceContract::class);
        $uploadServiceMock
            ->expects("upload")
            ->andReturn("teste");

        $uploadPhotoDto = new UserProfileSaveImageDto(Mockery::mock(UploadedFile::class), 2);

        $userProfileService = new UserProfileService($uploadServiceMock, $userRepository);
        $return = $userProfileService->savePhoto($uploadPhotoDto);
        expect($return)->toBeFalse();
    });
});
