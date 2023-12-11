<?php

use App\Models\User;

use function Pest\Laravel\post;

const DEFAULT_PASSWORD = "12345678";

describe("Testagem do login na api", function () {
    beforeEach(function () {
        $this->user = User::factory()->createOne([
            "password" => DEFAULT_PASSWORD
        ]);
    });

    test('Criar login, sucesso', function () {
        $return = (object) post(route("login"), [
            "email" => $this->user->email,
            "password" => DEFAULT_PASSWORD
        ])->assertStatus(200)->json("data");
        expect($return)->toHaveProperty("token");
    });

    test('Login com parametros errados não deve funcionar, erro', function (
        $parameter,
        $type
    ) {
        $userData = [
            "email" => $this->user->email,
            "password" => "4132413241"
        ];
        $userData[$type] = $parameter;
        $return = (object) post(route("login"), $userData)->assertStatus(401)->json();

        expect($return)->toHaveProperty("message", "Credenciais inválidas!")
            ->and($return)->toHaveProperty("type", false);
    })->with([
        "email"=> ["teste@teste.com", "email"],
        "password"=> ["123456789012312312", "password"]
    ]);
});
