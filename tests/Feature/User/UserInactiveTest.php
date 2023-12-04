<?php

use App\Enum\RolesUser;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;

describe("Testagem da rota de excluir usuário", function () {
    beforeEach(function () {
        $this->userNormal = User::factory(User::class)->createOne();
        $this->userAdmin = User::factory(User::class)->createOne([
            'role' => RolesUser::ADMIN->value
        ]);
    });

    test('Exclusão do próprio usuário logado, sucesso', function () {

        $return = actingAs($this->userNormal)
            ->delete(route('user.destroy', $this->userNormal->getKey()))
            ->assertStatus(200)->json("type");

        expect($return)->toBeTrue();
        expect(
            User::withTrashed()
                ->find($this->userNormal->getKey())->trashed()
        )->toBeTrue();
    });

    test('Admin pode excluir qualquer usuário, sucesso', function () {

        $return = actingAs($this->userAdmin)
            ->delete(route('user.destroy', $this->userNormal->getKey()))
            ->assertStatus(200)->json("type");

        expect($return)->toBeTrue();
        expect(
            User::withTrashed()
                ->find($this->userNormal->getKey())->trashed()
        )->toBeTrue();
    });

    test('Exclusão de outro usuário estando logado, erro', function () {

        $return = (object) actingAs($this->userNormal)
            ->delete(route('user.destroy', $this->userAdmin->getKey()))
            ->assertStatus(401)->json();

        expect($return)->toHaveProperty('message', 'Não autorizado!');
        expect($return)->toHaveProperty('type', false);
    });

    test('Exclusão de usuário não existe, erro', function () {
        $return = (object) actingAs($this->userAdmin)
            ->delete(route('user.destroy', 223))
            ->assertStatus(404)->json();

        expect($return)->toHaveProperty('message', 'Objeto não encontrado!');
        expect($return)->toHaveProperty('type', false);
    });

    test('Exclusão de usuário sem estar logado, erro', function () {

        $return = (object) delete(route('user.destroy', $this->userNormal->getKey()))
            ->assertStatus(401)->json();

        expect($return)->toHaveProperty('message', 'Não autorizado!');
        expect($return)->toHaveProperty('type', false);
    });
});
