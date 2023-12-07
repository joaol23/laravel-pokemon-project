<?php

use App\Dto\Pokemon\PokemonListTypesCreateDto;
use App\Models\Pokemon\PokemonTypes;
use App\Repositories\Pokemon\PokemonTypesRepository;
use App\Services\Pokemon\PokemonTypesService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

uses(\Tests\Objects\PokemonTypesFakeTrait::class);

describe("Testando service de tipos de pokemons", function () {
    beforeEach(function () {
        $this->pokemonTypesService = new PokemonTypesService(
            new PokemonTypesRepository()
        );
    });

    test("Testando método de criar tipos para pokemons", function () {
        $pokemonListTypeCreateDto = $this->pokemonListTypesCreateDto();
        $pokemonTypes = $this->pokemonTypesService->create($pokemonListTypeCreateDto);

        expect(PokemonTypes::all())
            ->toHaveCount(1);

        expect($pokemonTypes)
            ->toBeArray()
            ->toHaveCount(1)
            ->each()
            ->toBeInstanceOf(PokemonTypes::class);
    });

    test("Testando método de criar tipos iguais não deve criar novo", function () {
        $pokemonListTypeCreateDto = (new PokemonListTypesCreateDto())
            ->add($this->pokemonTypeCreateDto())
            ->add($this->pokemonTypeCreateDto());
        $pokemonTypes = $this->pokemonTypesService->create($pokemonListTypeCreateDto);

        expect(PokemonTypes::all())
            ->toHaveCount(1);

        expect($pokemonTypes)
            ->toBeArray()
            ->toHaveCount(2)
            ->each()
            ->toBeInstanceOf(PokemonTypes::class);
    });

    test("Testando método de busca por nome de tipo", function () {
        $typeDb = PokemonTypes::factory()
            ->createOne();

        $pokemonTypeSerach = $this->pokemonTypesService->getByName($typeDb->name);

        expect($pokemonTypeSerach)->toBeInstanceOf(PokemonTypes::class);

        expect($pokemonTypeSerach->name)->toEqual($typeDb->name);
        expect($pokemonTypeSerach->color)->toEqual($typeDb->color);
    });

    test("Testando busca de todos os tipos de pokemons", function () {
        PokemonTypes::factory(2)->create();
        $pokemons = $this->pokemonTypesService->listAll();

        expect($pokemons)->toHaveCount(2)
            ->toBeInstanceOf(LengthAwarePaginator::class);
    });
});
