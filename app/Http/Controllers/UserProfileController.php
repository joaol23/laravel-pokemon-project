<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserProfileServiceContract;
use App\Dto\User\UserProfileSaveImageDto;
use App\Http\Requests\User\UserProfileImageRequest;
use App\Http\Resources\Default\ApiResponseResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserProfileController extends Controller
{
    public function __construct(
        private readonly UserProfileServiceContract $userProfileService
    ) {
    }

    public function saveProfile(
        int $userId,
        UserProfileImageRequest $request
    ): ApiResponseResource|JsonResponse {
        $dto = new UserProfileSaveImageDto(
            $request->file('photo'),
            $userId
        );
        $savePhoto = $this->userProfileService
            ->savePhoto($dto);

        if ($savePhoto !== false) {
            return new ApiResponseResource([
                "path" => $savePhoto
            ], "Imagem salva com sucesso!");
        }

        return response()->json(new ApiResponseResource(
            message: "Erro ao salvar imagem!",
            type: false
        ), Response::HTTP_BAD_REQUEST);
    }
}
