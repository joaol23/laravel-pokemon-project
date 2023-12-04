<?php

use App\Models\Pokemon\Pokemon;
use function Pest\Laravel\get;

describe("Testando a listagem de pokemons", function () {
    test("Deve retornar uma lista de pokemons", function () {
        Pokemon::factory(3)
            ->create();
        $response = (object)get(route("pokemon.list"))
            ->assertStatus(200)
            ->json();

        expect($response->data)
            ->toBeArray()
            ->toHaveCount(3);

        expect($response->data[0])
            ->toHaveKeys(["id", "name", "image", "pokemon_id", "types"]);

        expect($response->current_page)
            ->toBe(1);

        expect($response->last_page)->toBe(1);

        expect($response->per_page)->toBe(30);

        expect($response->total)->toBe(3);

        expect($response->next_page_url)
            ->toBe(null);
    });

    test("Testando com lista vazia", function () {
        $response = (object)get(route("pokemon.list"))
            ->assertStatus(200)
            ->json();

        expect($response->data)
            ->toBeArray()
            ->toHaveCount(0);

        expect($response->current_page)
            ->toBe(1);

        expect($response->last_page)->toBe(1);

        expect($response->per_page)->toBe(30);

        expect($response->total)->toBe(0);

        expect($response->next_page_url)
            ->toBe(null);
    });
});
