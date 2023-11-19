<?php

use App\Enum\RolesUser;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

describe("Testagem dos fluxos de ver detalhes do usuário", function () {
    beforeEach(function () {
        $this->userNormal = User::factory(User::class)->createOne();
        $this->userAdmin = User::factory(User::class)->createOne([
            'role' => RolesUser::ADMIN->value
        ]);
    });

    test('Busca de informações do próprio usuario, sucesso', function () {
        $return = actingAs($this->userNormal)
            ->get(route('user.show', $this->userNormal->getKey()))
            ->assertStatus(200)->json("data");

        expect($return)->toBeArray();

        $returnObject = (object) $return;

        expect($returnObject)->toHaveProperty('id', $this->userNormal->id);
        expect($returnObject)->toHaveProperty('email', $this->userNormal->email);
        expect($returnObject)->toHaveProperty('name', $this->userNormal->name);
    });

    test('Busca de informações de outro usuario como admin, sucesso', function () {
        $return = actingAs($this->userAdmin)
            ->get(route('user.show', $this->userNormal->getKey()))
            ->assertStatus(200)->json("data");

        expect($return)->toBeArray();

        $returnObject = (object) $return;

        expect($returnObject)->toHaveProperty('id', $this->userNormal->id);
        expect($returnObject)->toHaveProperty('email', $this->userNormal->email);
        expect($returnObject)->toHaveProperty('name', $this->userNormal->name);
    });

    test('Busca de informações de outro usuario, erro', function () {
        $return = (object) actingAs($this->userNormal)
            ->get(route('user.show', $this->userAdmin->getKey()))
            ->assertStatus(401)->json();

        expect($return)->toHaveProperty('message', 'Não autorizado!');
        expect($return)->toHaveProperty('type', false);
    });

    test('Busca de informações de usuario estando deslogado, erro', function () {
        $return = (object) get(route('user.show', $this->userAdmin->getKey()))
            ->assertStatus(401)->json();

        expect($return)->toHaveProperty('message', 'Não autorizado!');
        expect($return)->toHaveProperty('type', false);
    });

    test('Busca de usuário não encontrado, erro', function () {
        $return = (object) actingAs($this->userAdmin)
            ->get(route('user.show', 13143))
            ->assertStatus(404)->json();

        expect($return)->toHaveProperty('message', 'Usuário não encontrado!');
        expect($return)->toHaveProperty('type', false);
    });
});
