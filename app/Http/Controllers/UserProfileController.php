<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserProfileServiceContract;
use App\Dto\User\UserProfileSaveImageInterface;
use App\Http\Requests\User\UserProfileImageRequest;
use Illuminate\Http\JsonResponse;

class UserProfileController extends Controller
{
    public function __construct(
        private readonly UserProfileServiceContract $userProfileService
    ) {
    }

    public function saveProfile(
        UserProfileImageRequest $request
    ): JsonResponse {
        $dto = new UserProfileSaveImageInterface($request->file('photo'));
        $savePhoto = $this->userProfileService
            ->savePhoto($dto);
        return response()->json(
            [
                "data"    => [
                ],
                "message" => $savePhoto ? "Imagem salva com sucesso!" : "Erro ao salvar imagem!",
                "type"    => $savePhoto
            ]
        );
    }
}
