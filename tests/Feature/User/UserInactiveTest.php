<?php

use App\Models\User;

use function Pest\Laravel\delete;

describe("Testagem da rota de excluir usuário", function () {
    test('Exclusão de usuário, sucesso', function () {
        $user = User::factory()->createOne();

        $return = delete(route('user.destroy', $user->getKey()))
            ->assertStatus(200)->json("type");

        expect($return)->toBeTrue();
        expect(
            User::withTrashed()
                ->find($user->getKey())->trashed()
        )->toBeTrue();
    });

    test('Exclusão de usuário, erro', function () {
        $return = (object) delete(route('user.destroy', 223))
            ->assertStatus(404)->json();


        expect($return)->toHaveProperty('message', 'Usuário não encontrado!');
        expect($return)->toHaveProperty('type', false);
    });
});
