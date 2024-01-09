<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Dto\User\UserUpdateDto;
use App\Http\Middleware\OnlyAdmin;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Utils\Params\ValidId;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService
    ) {
        $this->middleware(OnlyAdmin::class)
            ->only(['index', 'store']);
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->userService
                ->listAll()
        );
    }

    public function store(
        UserCreateRequest $request
    ): JsonResponse {
        $userDto = new UserCreateDto(
            $request->name,
            $request->email,
            $request->password
        );
        return response()->json([
            "data" => $this->userService
                ->create($userDto)
        ], Response::HTTP_CREATED);
    }

    public function show(
        int $id
    ): JsonResponse {
        return response()->json([
            "data" => $this->userService
                ->getById(ValidId::validate($id))
        ]);
    }

    public function update(
        UserUpdateRequest $request,
        int $id
    ) {
        $validatedData = (object)$request->validated();
        $userUpdateDto = new UserUpdateDto(
            $validatedData->name,
            $validatedData->email
        );
        return response()->json([
            "data" => $this->userService
                ->update(
                    $userUpdateDto,
                    $id
                )
        ]);
    }

    public function destroy(
        int $id
    ) {
        return response()->json([
            "type" => $this->userService
                ->inactive($id)
        ]);
    }
}
