<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\Auth\LoginDto;
use App\Dto\User\UserCreateDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Resources\Default\ApiResponseResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService,
        private readonly AuthServiceContract $authService,
    ) {
        $this->middleware("auth:sanctum")
            ->only("logout");
    }

    public function auth(
        LoginRequest $loginRequest
    ): ApiResponseResource {
        $loginDto = new LoginDto(
            $loginRequest->get("email"),
            $loginRequest->get("password")
        );
        $user = $this->authService->checkCredentials($loginDto);
        $token = $this->authService->generateToken($user);

        return new ApiResponseResource([
            "token" => $token,
        ], "Login realizado com sucesso!");
    }

    public function register(
        UserCreateRequest $userCreateRequest
    ): JsonResponse {
        $userDto = new UserCreateDto(
            $userCreateRequest->get("name"),
            $userCreateRequest->get("email"),
            $userCreateRequest->get("password")
        );

        $user = $this->userService
            ->create($userDto);

        $token = $this->authService->generateToken($user);
        $apiResponse = new ApiResponseResource(
            ["token" => $token],
            "Registro realizado com sucesso!"
        );
        return $apiResponse
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function logout(
        Request $request
    ): ApiResponseResource {
        return new ApiResponseResource(
            type: $this->authService
                ->deleteAllTokens($request->user())
        );
    }

    public function me(): UserResource
    {
        return new UserResource(auth()->user());
    }
}
