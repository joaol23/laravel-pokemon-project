<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Http\Requests\User\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService
    ) {
    }
    public function auth(Request $request)
    {
        $credentials = $request->only([
            'email',
            'password'
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user->tokens()->delete();
        $token = $user->createToken("user_" . $user->name)->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }

    public function register(UserCreateRequest $userCreateRequest)
    {
        $userDto = new UserCreateDto(
            $userCreateRequest->name,
            $userCreateRequest->email,
            $userCreateRequest->password
        );

        $user = $this->userService
        ->create($userDto);
        
        $user->tokens()->delete();
        $token = $user->createToken("user_" . $user->name)->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'type' => true
        ]);
    }
}
