<?php

use App\Models\User;

use function Pest\Laravel\get;

describe("Testagem dos fluxos de listar usuário/s", function () {
    test('Listagem de usuários, com dois usuários', function () {
        User::factory(2)->create();

        $return = get(route('user.index'))
            ->assertOk()->json("data");

        expect($return)->toBeArray();
        expect($return)->toHaveCount(2);

        expect((object) $return[0])->toHaveProperties(['id', 'name', 'email']);
    });

    test('Listagem de usuários, sem usuários', function () {
        $return = get(route('user.index'))
            ->assertOk()->json("data");

        expect($return)->toBeArray();
        expect($return)->toHaveCount(0);
    });

    test('Busca de usuário encontrado', function () {
        $user = User::factory()->createOne();

        $return = get(route('user.show', $user->getKey()))
            ->assertStatus(200)->json("data");

        expect($return)->toBeArray();

        $returnObject = (object) $return;

        expect($returnObject)->toHaveProperty('id', $user->id);
        expect($returnObject)->toHaveProperty('email', $user->email);
        expect($returnObject)->toHaveProperty('name', $user->name);
    });

    test('Busca de usuário, não encontrado', function () {
        $return = (object) get(route('user.show', 13143))
            ->assertStatus(404)->json();

        expect($return)->toHaveProperty('message', 'Usuário não encontrado!');
        expect($return)->toHaveProperty('type', false);
    });
});
