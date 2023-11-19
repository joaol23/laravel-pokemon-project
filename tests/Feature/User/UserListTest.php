<?php

use App\Enum\RolesUser;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

describe("Testagem dos fluxos de listar usuários, somente admin", function () {
    beforeEach(function () {
        $this->userNormal = User::factory(User::class)->createOne();
        $this->userAdmin = User::factory(User::class)->createOne([
            'role' => RolesUser::ADMIN->value
        ]);
    });

    test('Listagem de usuários como admin com dois usuários, sucesso', function () {
        $return = actingAs($this->userAdmin)
            ->get(route('user.index'))
            ->assertOk()->json("data");

        expect($return)->toBeArray();
        expect($return)->toHaveCount(2);

        expect((object) $return[0])->toHaveProperties(['id', 'name', 'email']);
    });

    test('Listagem de usuários como user normal, erro', function () {
        $return = (object) actingAs($this->userNormal)
            ->get(route('user.index'))
            ->assertUnauthorized()->json();

        expect($return)->toHaveProperty('message', 'Não autorizado!');
        expect($return)->toHaveProperty('type', false);
    });

    test('Listagem de usuários deslogado, erro', function () {
        $return = (object) get(route('user.index'))
            ->assertUnauthorized()->json();

        expect($return)->toHaveProperty('message', 'Não autorizado!');
        expect($return)->toHaveProperty('type', false);
    });
});