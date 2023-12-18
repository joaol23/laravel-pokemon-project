<?php

use App\Contracts\Repository\UserPokemonRepositoryContract;
use App\Contracts\Repository\UserRepositoryContract;
use App\Dto\UserPokemon\AddPokemonUserDto;
use App\Services\User\UserPokemonService;

describe(
    'AddUserPokemonUnitTest', function () {
    beforeEach(
        function () {
            $this->userRepository = Mockery::mock(UserRepositoryContract::class);
            $this->userPokemonRepository = Mockery::mock(UserPokemonRepositoryContract::class);
        }
    );

    test(
        "Tem que checar se ordem existe antes de adicionar", closure: function () {

        $this->userPokemonRepository
            ->shouldReceive('existsOfOrder')
            ->once()
            ->with(1, 1)
            ->andReturn(false);

        $this->userPokemonRepository
            ->shouldReceive('addPokemon')
            ->once()
            ->andReturn(true);

        $userPokemonService = new UserPokemonService($this->userPokemonRepository, $this->userRepository);

        $userPokemonService->addPokemon(
            new AddPokemonUserDto(
                1,
                1,
                1
            )
        );
    }
    );

    test(
        "Atualizar se ja existir ordem", closure: function () {

        $this->userPokemonRepository
            ->shouldReceive('existsOfOrder')
            ->once()
            ->with(1, 1)
            ->andReturn(true);

        $this->userPokemonRepository
            ->shouldReceive('addPokemon')
            ->never()
            ->andReturn(true);

        $this->userPokemonRepository
            ->shouldReceive('updatePokemon')
            ->once()
            ->andReturn([]);

        $userPokemonService = new UserPokemonService($this->userPokemonRepository, $this->userRepository);

        $userPokemonService->addPokemon(
            new AddPokemonUserDto(
                1,
                1,
                1
            )
        );
    }
    );
}
);
