<?php

use App\Contracts\Repository\UserRepositoryContract;
use App\Dto\Auth\LoginDto;
use App\Exceptions\Auth\AuthenticationCredentialsInvalid;
use App\Exceptions\InternalError;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

describe("Testando o método checkCredentials", function () {
    beforeEach(function () {
        $this->userRepository = Mockery::mock(UserRepositoryContract::class);
    });

    test('sucesso', function () {
        $this->userRepository
            ->shouldReceive('getByEmail')
            ->with('teste@teste.com')
            ->andReturn(new User(["password" => "12345678"]));

        $this->authService = new AuthService($this->userRepository);

        $loginDto = new LoginDto(
            "teste@teste.com",
            "12345678"
        );
        $user = $this->authService->checkCredentials($loginDto);

        expect($user)->toBeInstanceOf(User::class);
    });

    test('Usuário com email não encontrado', function () {
        $this->userRepository
            ->shouldReceive('getByEmail')
            ->with('teste@teste.com')
            ->andThrow(new ModelNotFoundException);
        $this->authService = new AuthService($this->userRepository);

        $loginDto = new LoginDto(
            "teste@teste.com",
            "12345678"
        );
        $this->authService->checkCredentials($loginDto);
    })->throws(AuthenticationCredentialsInvalid::class);

    test('Usuário com senha errada', function () {
        $this->userRepository
            ->shouldReceive('getByEmail')
            ->with("teste@teste.com")
            ->andReturn(new User(["password" => "12345678"]));
        $this->authService = new AuthService($this->userRepository);

        $loginDto = new LoginDto(
            "teste@teste.com",
            "123456789"
        );
        $this->authService->checkCredentials($loginDto);
    })->throws(AuthenticationCredentialsInvalid::class);

    test('Exception qualquer', function () {
        $this->userRepository
            ->shouldReceive('getByEmail')
            ->with('teste@teste.com')
            ->andThrow(new \Exception("Erro blá!"));
        $this->authService = new AuthService($this->userRepository);

        $loginDto = new LoginDto(
            "teste@teste.com",
            "123456789"
        );
        $this->authService->checkCredentials($loginDto);
    })->throws(
        InternalError::class,
        "Não foi possível realizar o login no momento!"
    );
});
