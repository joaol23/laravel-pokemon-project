<?php

use App\Models\Pokemon\Pokemon;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\post;

describe(
    "Testando fluxo de adicionar pokemon à um usuário",
    function () {
        beforeEach(
            function () {
                $this->user = User::factory()
                    ->create();
                $this->pokemon = Pokemon::factory()
                    ->create();
            }
        );

        test(
            "Pokemon sendo adicionado a um usuario logado, sucesso",
            function () {
                $response = $this->actingAs($this->user)
                    ->post(
                        route(
                            "user.add.pokemon",
                            [
                                $this->user->id,
                                $this->pokemon->id
                            ]
                        ),
                        ["order" => 1]
                    )
                    ->assertStatus(Response::HTTP_CREATED)
                    ->assertJson(
                        [
                            "type"    => true,
                            "message" => "Pokemon adicionado com sucesso!"
                        ]
                    );

                $this->assertDatabaseHas(
                    "users_pokemons",
                    [
                        "user_id"    => $this->user->id,
                        "pokemon_id" => $this->pokemon->id
                    ]
                );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(1);
            }
        );

        test(
            "Pokemon sendo adicionado a um usuario não logado, erro",
            function () {
                $response = post(
                    route(
                        "user.add.pokemon",
                        [
                            $this->user->id,
                            $this->pokemon->id
                        ]
                    ),
                    ["order" => 1]
                )
                    ->assertStatus(Response::HTTP_UNAUTHORIZED)
                    ->assertJson(
                        [
                            "type"    => false,
                            "message" => "Não autorizado!"
                        ]
                    );

                $this->assertDatabaseMissing(
                    "users_pokemons",
                    [
                        "user_id"    => $this->user->id,
                        "pokemon_id" => $this->pokemon->id
                    ]
                );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(0);
            }
        );

        test(
            "Pokemon sendo adicionado a um usuario logado, mas pokemon não existe, erro",
            function () {
                $response = $this->actingAs($this->user)
                    ->post(
                        route(
                            "user.add.pokemon",
                            [
                                $this->user->id,
                                412412
                            ]
                        ),
                        ["order" => 1]
                    )
                    ->assertStatus(400)
                    ->assertJson(
                        [
                            "type"    => false,
                            "message" => "Error ao selecionar pokemon!"
                        ]
                    );
            }
        );

        test(
            "Pokemon sendo adicionado a um usuario logado, mas pokemon de mesma ordem já adicionado, não duplicar",
            function () {
                $this->user->pokemons()
                    ->attach($this->pokemon->id, ["order" => 1]);

                $response = $this->actingAs($this->user)
                    ->post(
                        route(
                            "user.add.pokemon",
                            [
                                $this->user->id,
                                $this->pokemon->id
                            ]
                        ),
                        ["order" => 1]
                    )
                    ->assertStatus(201)
                    ->assertJson(
                        [
                            "type"    => true,
                            "message" => "Pokemon adicionado com sucesso!"
                        ]
                    );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(1);
            }
        );

        test(
            "Usuario tentando adicionar em outro usuario, erro",
            function () {
                $user2 = User::factory()
                    ->create();

                $response = $this->actingAs($user2)
                    ->post(
                        route(
                            "user.add.pokemon",
                            [
                                $this->user->id,
                                $this->pokemon->id
                            ]
                        ),
                        ["order" => 1]
                    )
                    ->assertStatus(401)
                    ->assertJson(
                        [
                            "type"    => false,
                            "message" => "Não autorizado!"
                        ]
                    );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(0);
            }
        );

        test(
            "Usuario tentando adicionar pokemon com ordem inválida, erro",
            function () {
                $response = $this->actingAs($this->user)
                    ->post(
                        route(
                            "user.add.pokemon",
                            [
                                $this->user->id,
                                $this->pokemon->id
                            ]
                        ),
                        ["order" => 0]
                    )
                    ->assertStatus(422)
                    ->assertJson(
                        [
                            "message" => "Dados inválidos",
                            "errors"  => [
                                "order" => [
                                    "O campo order precisa conter pelo menos 1."
                                ]
                            ]
                        ]
                    );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(0);
            }
        );

        test(
            "Adicionando mesmo pokemon em ordens diferentes",
            function () {
                $this->user->pokemons()
                    ->attach($this->pokemon->id, ["order" => 1]);

                $response = $this->actingAs($this->user)
                    ->post(
                        route(
                            "user.add.pokemon",
                            [
                                $this->user->id,
                                $this->pokemon->id
                            ]
                        ),
                        ["order" => 2]
                    )
                    ->assertStatus(201)
                    ->assertJson(
                        [
                            "type"    => true,
                            "message" => "Pokemon adicionado com sucesso!"
                        ]
                    );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(2);
            }
        );

        test(
            "Adicionar pokemon em mesma ordem, quando tem dois pokemons iguais em ordem diferente",
            function () {
                $this->user->pokemons()
                    ->attach($this->pokemon->id, ["order" => 1]);
                $this->user->pokemons()
                    ->attach($this->pokemon->id, ["order" => 2]);

                $pokemon2 = Pokemon::factory()
                    ->create();

                $response = $this->actingAs($this->user)
                    ->post(
                        route(
                            "user.add.pokemon",
                            [
                                $this->user->id,
                                $pokemon2->id
                            ]
                        ),
                        ["order" => 1]
                    )
                    ->assertStatus(201)
                    ->assertJson(
                        [
                            "type"    => true,
                            "message" => "Pokemon adicionado com sucesso!"
                        ]
                    );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(2);
            }
        );
    }
);
