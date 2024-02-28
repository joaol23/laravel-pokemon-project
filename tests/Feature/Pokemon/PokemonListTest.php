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

        expect($response->pagination["current_page"])
            ->toBe(1);

        expect($response->pagination["last_page"])->toBe(1);

        expect($response->pagination["per_page"])->toBe(30);

        expect($response->pagination["total"])->toBe(3);

        expect($response->links["next"])
            ->toBe(null);
    });

    test("Testando com lista vazia", function () {
        $response = (object)get(route("pokemon.list"))
            ->assertStatus(200)
            ->json();

        expect($response->data)
            ->toBeArray()
            ->toHaveCount(0);

        expect($response->pagination["current_page"])
            ->toBe(1);

        expect($response->pagination["last_page"])->toBe(1);

        expect($response->pagination["per_page"])->toBe(30);

        expect($response->pagination["total"])->toBe(0);

        expect($response->links["next"])
            ->toBe(null);
    });

    test("Testando lista com busca", function () {
        Pokemon::factory()
            ->createOne([
                "name" => "charmander"
            ]);
        Pokemon::factory()
            ->createOne();

        $response = (object)get(route("pokemon.list", ["q" => "Charmander"]))
            ->assertStatus(200)
            ->json();

        expect($response->data)
            ->toBeArray()
            ->toHaveCount(1);

        expect($response->data[0])
            ->toHaveKeys(["id", "name", "image", "pokemon_id", "types"]);

        expect($response->pagination["current_page"])
            ->toBe(1);

        expect($response->pagination["last_page"])->toBe(1);

        expect($response->pagination["per_page"])->toBe(30);

        expect($response->pagination["total"])->toBe(1);

        expect($response->links["next"])
            ->toBe(null);
    });
});
