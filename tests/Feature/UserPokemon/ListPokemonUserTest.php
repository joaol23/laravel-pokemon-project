<?php

use App\Models\Pokemon\Pokemon;
use App\Models\User;
use function Pest\Laravel\actingAs;

describe('Testando o fluxo de listagem de pokemons de usuarios', function () {
    beforeEach(function () {
        $this->user = User::factory()
            ->createOne();
        $this->pokemon = Pokemon::factory()
            ->createOne();
    });

    test('Usuario sem pokemons tem que retornar lista vazia', function () {
        $return = actingAs($this->user)
            ->get(route('user.list.pokemon',
                [
                    $this->user->id
                ]))
            ->assertStatus(200)
            ->json("data");

        expect($return)
            ->toBeArray()
            ->toBeEmpty();
    });

    test('Usuario com pokemons tem que retornar lista com pokemons', function () {
        $this->user->pokemons()
            ->attach($this->pokemon->id);
        $return = actingAs($this->user)
            ->get(route('user.list.pokemon',
                [
                    $this->user->id
                ]))
            ->assertStatus(200)
            ->json("data");

        expect($return)
            ->toBeArray()
            ->toHaveCount(1);

        expect($return[0])->toHaveKeys([
            'id',
            'name',
            'types',
            'pivot'
        ]);
    });

    test('Usuario nao autenticado nao pode listar pokemons', function () {
        $return = $this->get(route('user.list.pokemon',
                [
                    $this->user->id
                ]))
            ->assertStatus(401)
            ->json("message");

        expect($return)
            ->toBeString()
            ->toEqual("Não autorizado!");
    });

    test('Usuario nao pode listar pokemons de outro usuario', function () {
        $user2 = User::factory()
            ->createOne();
        $return = actingAs($user2)
            ->get(route('user.list.pokemon',
                [
                    $this->user->id
                ]))
            ->assertStatus(401)
            ->json("message");

        expect($return)
            ->toBeString()
            ->toEqual("Não autorizado!");
    });
});
