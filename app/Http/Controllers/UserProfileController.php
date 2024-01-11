<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserProfileServiceContract;
use App\Dto\User\UserProfileSaveImageDto;
use App\Http\Requests\User\UserProfileImageRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserProfileController extends Controller
{
    public function __construct(
        private readonly UserProfileServiceContract $userProfileService
    ) {
    }

    public function saveProfile(
        UserProfileImageRequest $request
    ): JsonResponse {
        $dto = new UserProfileSaveImageDto($request->file('photo'));
        $savePhoto = $this->userProfileService
            ->savePhoto($dto);

        if ($savePhoto !== false) {
            return response()->json(
                [
                    "data"    => [
                        "path" => $savePhoto
                    ],
                    "message" => "Imagem salva com sucesso!",
                    "type"    => true
                ]
            );
        }

        return response()->json([
            "message" => "Erro ao salvar imagem!",
            "type"    => false
        ], Response::HTTP_BAD_REQUEST);
    }
}
