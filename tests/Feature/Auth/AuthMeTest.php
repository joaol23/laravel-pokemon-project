<?php

use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

describe("Testagem da rota de me", function () {
    beforeEach(function () {
        $this->user = User::factory()
            ->createOne([
                "password" => "12345678"
            ]);
        $return = (object)post(route("login"), [
            "email"    => $this->user->email,
            "password" => "12345678"
        ])
            ->assertStatus(200)
            ->json("data");
        $this->token = $return->token;
    });

    test('me, sucesso', function () {
        $return = (object)get(
            route('about.me'),
            headers: ['Authorization' => 'Bearer ' . $this->token]
        )
            ->assertStatus(200)
            ->json("data.user");

        expect($return)->toHaveProperty("name", $this->user->name);
        expect($return)->toHaveProperty("email", $this->user->email);
        expect($return)->toHaveProperty("created_at");
        expect($return)->toHaveProperty("updated_at");
        expect($return)->toHaveProperty("id", $this->user->id);
    });

    test('me sem token, erro', function () {
        $return = (object)get(
            route('about.me')
        )
            ->assertStatus(401)
            ->json();

        expect($return)->toHaveProperty('message', "Não autorizado!");
        expect($return)->toHaveProperty('type', false);
    });
});
