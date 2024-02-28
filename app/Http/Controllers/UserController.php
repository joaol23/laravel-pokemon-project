<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Dto\User\UserUpdateDto;
use App\Http\Middleware\OnlyAdmin;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\Default\ApiResponseResource;
use App\Http\Resources\UserCollectionResource;
use App\Http\Resources\UserResource;
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

    public function index(): UserCollectionResource
    {
        return new UserCollectionResource(
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
        return (new ApiResponseResource(
            new UserResource(
                $this->userService
                    ->create($userDto)
            )
        ))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(
        int $id
    ): UserResource {
        return new UserResource($this->userService
            ->getById(ValidId::validate($id)));
    }

    public function update(
        UserUpdateRequest $request,
        int $id
    ): UserResource {
        $validatedData = (object)$request->validated();
        $userUpdateDto = new UserUpdateDto(
            $validatedData->name,
            $validatedData->email
        );
        return new UserResource($this->userService
            ->update(
                $userUpdateDto,
                $id
            )
        );
    }

    public function destroy(
        int $id
    ): ApiResponseResource {
        return new ApiResponseResource(
            type: $this->userService
                ->inactive($id)
        );
    }
}
