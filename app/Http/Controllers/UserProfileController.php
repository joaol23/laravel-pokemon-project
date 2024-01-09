<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserProfileServiceContract;
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
        $savePhoto = $this->userProfileService->savePhoto();
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
