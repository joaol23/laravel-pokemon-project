<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\post;

describe("Testagem do processo de criação de usuário", function () {

    test('Adicionar novo usuário, sucesso', function () {
        $newUser = getFakeUser();

        $return = (object) post(route("user.store"), $newUser)
            ->assertStatus(201)->json("data");

        expect($return)->toHaveProperty("name", $newUser["name"]);
        expect($return)->toHaveProperty("email", $newUser["email"]);

        $userDb = User::find($return->id);
        expect($userDb)->toBeObject(User::class);
        expect(Hash::check($newUser["password"], $userDb->password))->toBeTrue();
    });

    test('Adicionar usuário sem parâmetro, erro', function (string $parameterRemove) {
        $newUser = getFakeUser(email: "john" . $parameterRemove . "@smith.com");
        unset($newUser[$parameterRemove]);

        $return = (object) post(route("user.store"), $newUser)
            ->assertStatus(422)->json();
        expect($return)->toHaveProperty("message", "Dados inválidos");
        expect($return)->toHaveProperty("errors");
        expect($return->errors)->toBeArray();
        expect($return->errors[$parameterRemove][0])->toBe(
            "O campo " . trans_choice("validation.attributes." . $parameterRemove, 1) . " é obrigatório."
        );
    })->with(["name", "email", "password"]);

    test('Adicionar dois emails iguais, erro', function () {
        $return = (object) post(route("user.store"), getFakeUser())
            ->assertStatus(201);

        $return = (object) post(route("user.store"), getFakeUser())
            ->assertStatus(422)->json();

        expect($return)->toHaveProperty("message", "Dados inválidos");
        expect($return)->toHaveProperty("errors");
        expect($return->errors)->toBeArray();
        expect($return->errors['email'][0])->toBe(
            "E-mail já utilizado!"
        );
    });

    test('Adicionar com confirmação de senha errada, erro', function () {
        $return = (object) post(route("user.store"), getFakeUser(password: "123456789"))
            ->assertStatus(422)->json();

        expect($return)->toHaveProperty("message", "Dados inválidos");
        expect($return)->toHaveProperty("errors");
        expect($return->errors)->toBeArray();
        expect($return->errors['password'][0])->toBe(
            "As senhas não são as mesmas!"
        );
    });

    function getFakeUser(?string $email = null, ?string $password = null)
    {
        return [
            "name" => "John Smith",
            "email" => $email ?? "john@smith.com",
            "password" => $password ?? "12345678",
            "password_confirmation" => "12345678"
        ];
    }
});
