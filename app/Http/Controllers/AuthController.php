<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\Auth\LoginDto;
use App\Dto\User\UserCreateDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\UserCreateRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService,
        private readonly AuthServiceContract $authService,
    ) {
    }
    public function auth(
        LoginRequest $loginRequest
    ) {
        $loginDto = new LoginDto(
            $loginRequest->email,
            $loginRequest->password
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
    ) {
        $userDto = new UserCreateDto(
            $userCreateRequest->name,
            $userCreateRequest->email,
            $userCreateRequest->password
        );

        $user = $this->userService
            ->create($userDto);

        $token = $this->authService->generateToken($user);
        return response()->json([
            "data" => [
                'token' => $token
            ]
        ]);
    }

    public function logout(
        Request $request
    ) {
        return response()->json([
            "data" => [
                'type' =>
                $this->authService->deleteAllTokens($request->user())
            ]
        ]);
    }
}
