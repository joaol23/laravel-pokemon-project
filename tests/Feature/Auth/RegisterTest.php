<?php

use Tests\Objects\UserFakeTrait;
use function Pest\Laravel\post;

describe("Teste do registro na api", function () {
    uses(UserFakeTrait::class);

    test('Registrar novo usuário, sucesso', function () {
        $newUser = $this->getFakeUser();

        $return = (object)post(route("register"), $newUser)
            ->assertStatus(201)
            ->json("data");

        expect($return)->toHaveProperty("token");
    });

    test('Registrar usuário sem parâmetro, erro', function (string $parameterRemove) {
        $newUser = $this->getFakeUser(email: "john" . $parameterRemove . "@smith.com");
        unset($newUser[$parameterRemove]);

        $return = (object)post(route("register"), $newUser)
            ->assertStatus(422)
            ->json();
        expect($return)->toHaveProperty("message", "Dados inválidos");
        expect($return)->toHaveProperty("errors");
        expect($return->errors)->toBeArray();
        expect($return->errors[$parameterRemove][0])->toBe(
            "O campo " . trans_choice("validation.attributes." . $parameterRemove, 1) . " é obrigatório."
        );
    })->with(["name", "email", "password"]);

    test('Registrar dois emails iguais, erro', function () {
        $return = (object)post(route("register"), $this->getFakeUser())
            ->assertStatus(201);

        $return = (object)post(route("register"), $this->getFakeUser())
            ->assertStatus(422)
            ->json();

        expect($return)->toHaveProperty("message", "Dados inválidos");
        expect($return)->toHaveProperty("errors");
        expect($return->errors)->toBeArray();
        expect($return->errors['email'][0])->toBe(
            "E-mail já utilizado!"
        );
    });

    test('Registro com confirmação de senha errada, erro', function () {
        $return = (object)post(route("register"), $this->getFakeUser(password: "123456789"))
            ->assertStatus(422)
            ->json();

        expect($return)->toHaveProperty("message", "Dados inválidos");
        expect($return)->toHaveProperty("errors");
        expect($return->errors)->toBeArray();
        expect($return->errors['password'][0])->toBe(
            "As senhas não são as mesmas!"
        );
    });
});
