<?php

use App\Models\Pokemon\Pokemon;
use App\Models\Pokemon\PokemonTypes;
use App\Repositories\Pokemon\PokemonRepository;
use App\Repositories\Pokemon\PokemonTypesRepository;
use App\Services\Pokemon\PokemonService;
use App\Services\Pokemon\PokemonTypesService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Tests\Objects\PokemonFakeTrait;
use Tests\Objects\PokemonTypesFakeTrait;

uses(PokemonFakeTrait::class, PokemonTypesFakeTrait::class);

describe("Testando fluxo do serviço de pokemon", function () {
    beforeEach(
        function () {
            $this->pokemonService = new PokemonService(
                new PokemonRepository(),
                new PokemonTypesService(
                    new PokemonTypesRepository()
                )
            );
        }
    );

    test('Testando criação de pokemons e seus tipos', function () {
        $pokemonCreateDto = $this->pokemonCreateDto();
        $pokemonListTypesCreateDto = $this->pokemonListTypesCreateDto();

        $pokemon = $this->pokemonService->create($pokemonCreateDto, $pokemonListTypesCreateDto);

        expect($pokemon)->toBeInstanceOf(Pokemon::class);
        expect($pokemon->name)->toBe($pokemonCreateDto->name);
        expect($pokemon->image)->toBe($pokemonCreateDto->image);

        expect($pokemon->types()
                   ->get()
        )->toBeInstanceOf(Collection::class);
        expect(
            $pokemon->types()
                ->get()
                ->count()
        )->toBe(1);
        expect(
            $pokemon->types()
                ->first()
        )->toBeInstanceOf(PokemonTypes::class);
    });

    test("Testando busca de todos os pokemons", function () {
        Pokemon::factory(2)->create();
        $pokemons = $this->pokemonService->listAll();

        expect($pokemons)->toHaveCount(2)
            ->toBeInstanceOf(LengthAwarePaginator::class);
    });

    test("Testando chegam de existir pokemon pelo nome", function () {
        $pokemonDb = Pokemon::factory()->createOne();

        expect($this->pokemonService->existsByName($pokemonDb->name))
            ->toBeTrue();

        expect($this->pokemonService->existsByName("johnathas"))
            ->toBeFalse();
    });
});
