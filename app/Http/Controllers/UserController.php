<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Dto\User\UserUpdateDto;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Utils\Params\ValidId;

class UserController extends Controller
{

    public function __construct(
        private readonly UserServiceContract $userService
    ) {
    }

    public function index()
    {
        return response()->json([
            "data" => $this->userService
                ->listAll()
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        $validatedData = (object) $request->validated();
        $userDto = new UserCreateDto(
            $validatedData->name,
            $validatedData->email,
            $validatedData->password
        );

        return response()->json([
            "data" => $this->userService
                ->create($userDto)
        ], 201);
    }

    public function show(mixed $id)
    {
        return response()->json([
            "data" => $this->userService
                ->getById(ValidId::validate($id))
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $validatedData = (object) $request->validated();
        $userUpdateDto = new UserUpdateDto(
            $validatedData->name,
            $validatedData->email
        );
        return response()->json([
            "data" => $this->userService
                ->update(
                    $userUpdateDto,
                    $user
                )
        ]);
    }

    public function destroy(int $id)
    {
        return response()->json([
            "type" => $this->userService
                ->inactive($id)
        ]);
    }
}
