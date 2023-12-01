<?php

use App\Jobs\MigratePokemonsJob;
use App\Models\Pokemon\Pokemon;
use App\Models\Pokemon\PokemonTypes;

describe("Testando fluxo de migração de pokemons", tests: function () {
    test('Testando fluxo', closure: function () {
        $infoPokemon = (\Nette\Utils\Json::decode(file_get_contents(base_path('tests/Fixtures/pokemon.json'))));
        MigratePokemonsJob::dispatchSync(1,1);
        expect(Pokemon::all())
            ->toHaveCount(1);

        $pokemon = Pokemon::query()->find(1);
        expect($pokemon->name)->toEqual($infoPokemon->name);
        expect($pokemon->pokemon_id)->toEqual($infoPokemon->id);
        expect($pokemon->image)->toEqual($infoPokemon->sprites->front_default);


        expect(Pokemon::query()->find(1)->types()->get())
            ->toHaveCount(1)
            ->and(Pokemon::query()->find(1)->types()->first())
            ->toBeInstanceOf(PokemonTypes::class)
            ->and((object)Pokemon::query()->find(1)->types()->first()->getAttributes())
            ->toHaveProperty("name", "normal")
            ->toHaveProperty("color", "white");
    });
});
