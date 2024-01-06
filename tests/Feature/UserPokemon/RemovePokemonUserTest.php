<?php

use App\Models\Pokemon\Pokemon;
use App\Models\User;

function attachPokemon(int $order, User $user): void
{
    $user->pokemons()
        ->attach(
            (Pokemon::factory()
                ->create())->id,
            ["order" => $order]
        );

}

describe(
    "Remove pokemon pela ordenação",
    function () {
        beforeEach(
            function () {
                $this->orderDefault = 5;
                $this->user = User::factory()
                    ->create();
                $this->user->pokemons()
                    ->attach(
                        (Pokemon::factory()
                            ->create())->id,
                        ["order" => $this->orderDefault]
                    );
            }
        );

        test(
            "Pokemon sendo removido na posição default, sucesso",
            function () {
                $this->actingAs($this->user)
                    ->delete(
                        route(
                            "user.remove.pokemon",
                            [
                                $this->user->id,
                                $this->orderDefault
                            ]
                        )
                    )
                    ->assertStatus(\Symfony\Component\HttpFoundation\Response::HTTP_OK)
                    ->assertJson(
                        [
                            "type"    => true,
                            "message" => "Pokemon removido com sucesso!"
                        ]
                    );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(0);
            }
        );

        test(
            "Só um pokemon sendo removido no delete na posição correta, sucesso",
            function () {
                attachPokemon(($this->orderDefault - 1), $this->user);
                attachPokemon(($this->orderDefault + 1), $this->user);
                $this->actingAs($this->user)
                    ->delete(
                        route(
                            "user.remove.pokemon",
                            [
                                $this->user->id,
                                $this->orderDefault
                            ]
                        )
                    )
                    ->assertStatus(\Symfony\Component\HttpFoundation\Response::HTTP_OK)
                    ->assertJson(
                        [
                            "type"    => true,
                            "message" => "Pokemon removido com sucesso!"
                        ]
                    );

                expect(
                    $this->user->pokemons()
                        ->get()
                )->toHaveCount(2);

                expect(
                    $this->user->pokemons()
                        ->wherePivot('order', "=", $this->orderDefault)
                        ->get()
                )->toHaveCount(0);
            }
        );

        test("Pokemon sendo removido em uma posição não existente, erro", function () {
            $this->actingAs($this->user)
                ->delete(
                    route(
                        "user.remove.pokemon",
                        [
                            $this->user->id,
                            ($this->orderDefault + 1)
                        ]
                    )
                )
                ->assertStatus(\Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST)
                ->assertJson(
                    [
                        "type"    => false,
                        "message" => "Sem pokemon nessa posição!"
                    ]
                );

            expect(
                $this->user->pokemons()
                    ->get()
            )->toHaveCount(1);
        });

        test("Usuário não logado tentando remover pokemon de alguém, erro", function () {
            $this->delete(
                route(
                    "user.remove.pokemon",
                    [
                        $this->user->id,
                        ($this->orderDefault + 1)
                    ]
                )
            )
                ->assertStatus(\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED)
                ->assertJson(
                    [
                        "type"    => false,
                        "message" => "Não autorizado!"
                    ]
                );

            expect(
                $this->user->pokemons()
                    ->get()
            )->toHaveCount(1);
        });

        test("Usuário logado tentando remover o pokemon de outra pessoa, erro", function () {
            $badUser = User::factory()
                ->createOne();
            $this->actingAs($badUser)
                ->delete(
                    route(
                        "user.remove.pokemon",
                        [
                            $this->user->id,
                            ($this->orderDefault + 1)
                        ]
                    )
                )
                ->assertStatus(\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED)
                ->assertJson(
                    [
                        "type"    => false,
                        "message" => "Não autorizado!"
                    ]
                );

            expect(
                $this->user->pokemons()
                    ->get()
            )->toHaveCount(1);
        });
    }
);
