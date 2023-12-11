<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\Auth\LoginDto;
use App\Dto\User\UserCreateDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\UserCreateRequest;
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
    ): JsonResponse {
        $loginDto = new LoginDto(
            $loginRequest->get('email'),
            $loginRequest->get('password')
        );
        $user = $this->authService->checkCredentials($loginDto);
        $token = $this->authService->generateToken($user);

        return response()->json([
            "data" => [
                'token' => $token
            ]
        ]);
    }

    public function register(
        UserCreateRequest $userCreateRequest
    ): JsonResponse {
        $userDto = new UserCreateDto(
            $userCreateRequest->get('email'),
            $userCreateRequest->get('email'),
            $userCreateRequest->get('password')
        );

        $user = $this->userService
            ->create($userDto);

        $token = $this->authService->generateToken($user);
        return response()->json([
            "data" => [
                'token' => $token
            ]
        ], Response::HTTP_CREATED);
    }

    public function logout(
        Request $request
    ): JsonResponse {
        return response()->json([
            "data" => [
                'type' =>
                    $this->authService
                        ->deleteAllTokens($request->user())
            ]
        ]);
    }

    public function me(): JsonResponse
    {
        return response()->json([
            "data" => [
                'user' => auth()->user()
            ]
        ]);
    }
}
