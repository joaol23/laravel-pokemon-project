<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceContract;
use App\Dto\User\UserCreateDto;
use App\Http\Requests\User\UserCreateRequest;
use App\Utils\Params\ValidateId;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        private readonly UserServiceContract $userService
    ) {
    }

    public function index()
    {
        return response()->json([
            "data" => $this->userService->listAll()
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        $validateData = (object) $request->validated();
        $userDto = new UserCreateDto(
            $validateData->name,
            $validateData->email,
            $validateData->password
        );

        return response()->json([
            "data" => $this->userService->create($userDto)
        ], 201);
    }

    public function show(mixed $id)
    {
        return response()->json([
            "data" => $this->userService->getById(ValidateId::validate($id))
        ]);
    }

    public function update(Request $request, mixed $id)
    {
        
    }

    public function destroy(string $id)
    {
        //
    }
}
