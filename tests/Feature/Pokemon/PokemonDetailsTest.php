<?php

use function Pest\Laravel\get;

describe("Testando a rota de buscar detalhes de um pokemon", function () {
    test("Deve retornar os detalhes de um pokemon", function () {
        $response = (object)get(route("pokemon.details", ["name" => "ditto"]))
            ->assertStatus(200)
            ->json("data");
        expect($response->name)->toBe("ditto");

        expect($response->types)
            ->toBeArray()
            ->toHaveCount(1)
            ->and($response->types[0])
            ->toBe("normal");

        expect($response)->toHaveKeys([
            "name", "types", "imageUrl", "imageUrlShiny", "stats", "weight"
        ]);
    });

    test("Deve retornar erro 404 quando o pokemon não existir", function () {
        $response = (object)get(route("pokemon.details", ["name" => "teste"]))
            ->assertStatus(404)
            ->json();

        expect($response->message)->toBe("Pokemon não encontrado!");
    });
});
