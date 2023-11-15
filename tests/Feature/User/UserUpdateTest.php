<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\put;

describe("Testagem da rota de atualizar usuário", function () {
    beforeEach(function () {
        $this->user = User::factory()->createOne();
    });

    test('Atualizar propriedade de usuário, sucesso', function () {
        $newDataUser = [
            "name" => "John Smith",
            "email" => "john@example.com",
        ];
        $response = (object) put(
            route('user.update', $this->user->id),
            $newDataUser
        )->assertStatus(200)->json("data");

        expect($response)->toHaveProperty("id", $this->user->id);
        expect($response)->toHaveProperty("name", $newDataUser['name']);
        expect($response)->toHaveProperty("email", $newDataUser['email']);
    });

    test('Email alterado não pode já existir no banco, erro', function () {
        $userDb2 = User::factory()->createOne();

        $newDataUser = [
            "name" => "John Smith",
            "email" => $userDb2->email,
        ];

        $response = (object) put(
            route('user.update', $this->user->id),
            $newDataUser
        )->assertStatus(422)->json();

        expect($response)->toHaveProperty("message", "Dados inválidos");
        expect($response)->toHaveProperty("errors");
        expect($response->errors)->toBeArray();
        expect($response->errors['email'][0])->toBe(
            "E-mail já utilizado!"
        );
    });

    test('Adicionar usuário sem parâmetro, erro', function (string $parameterRemove) {
        $newDataUser = [
            "name" => "John Smith",
            "email" => "john@example.com",
        ];
        unset($newDataUser[$parameterRemove]);

        $return = (object) put(route("user.update", $this->user->id), $newDataUser)
            ->assertStatus(422)->json();

        expect($return)->toHaveProperty("message", "Dados inválidos");
        expect($return)->toHaveProperty("errors");
        expect($return->errors)->toBeArray();
        expect($return->errors[$parameterRemove][0])->toBe(
            "O campo " . trans_choice("validation.attributes." . $parameterRemove, 1) . " é obrigatório."
        );
    })->with(["name", "email"]);

    test('Não pode alterar senha, sucesso', function () {
        $newDataUser = [
            "name" => "John Smith",
            "email" => "john@example.com",
            "password" => "50404040"
        ];

        $response = (object) put(route("user.update", $this->user->id), $newDataUser)
            ->assertStatus(200)->json("data");

        expect($response)->toHaveProperty("id", $this->user->id);
        expect($response)->toHaveProperty("name", $newDataUser['name']);
        expect($response)->toHaveProperty("email", $newDataUser['email']);
        expect(Hash::check($newDataUser["password"], User::find($this->user->id)->password))->toBeFalse();
    });
});
