<?php

use App\Models\User;

use function Pest\Laravel\delete;

test('Exclusão de usuário, sucesso', function () {
    $user = User::factory()->createOne();

    $return = delete(route('user.destroy', $user->getKey()))
        ->assertStatus(200)->json("type");

    expect($return)->toBeTrue();
});

test('Exclusão de usuário, erro', function () {
    $return = (object) delete(route('user.destroy', 223))
        ->assertStatus(404)->json();


    expect($return)->toHaveProperty('message', 'Dado não encontrado!');
    expect($return)->toHaveProperty('type', false);
});
