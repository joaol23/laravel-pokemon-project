<?php

use App\Jobs\MigratePokemonsJob;
use App\Models\Pokemon\Pokemon;
use App\Models\Pokemon\PokemonTypes;

describe("Testando fluxo de migração de pokemons", tests: function () {
    test('Testando fluxo', closure: function () {
        MigratePokemonsJob::dispatchSync(1,1);
        expect(Pokemon::all())
            ->toHaveCount(1);

        expect(Pokemon::query()->find(1)->types()->get())
            ->toHaveCount(1)
            ->and(Pokemon::query()->find(1)->types()->first())
            ->toBeInstanceOf(PokemonTypes::class)
            ->and((object)Pokemon::query()->find(1)->types()->first()->getAttributes())
            ->toHaveProperty("name", "normal")
            ->toHaveProperty("color", "white");
    });
});
