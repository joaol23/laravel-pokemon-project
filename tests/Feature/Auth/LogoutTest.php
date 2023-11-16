<?php

use App\Models\User;

use function Pest\Laravel\post;

describe("Testagem da rota de logout", function() {
    beforeEach(function () {
        $user = User::factory()->createOne([
            "password" => "12345678"
        ]);
        $return = (object) post(route("login"), [
            "email" => $user->email,
            "password" => "12345678"
        ])->assertStatus(200)->json("data");
        $this->token = $return->token;
    });
    
    test('Logout, sucesso', function () {
        post(
            route('logout'),
            headers: ['Authorization' => 'Bearer ' . $this->token]
        )->assertStatus(200);
    
        $this->app->get('auth')->forgetGuards();
    
        $return = (object) post(
            route('logout'),
            headers: ['Authorization' => 'Bearer ' . $this->token]
        )->assertStatus(401)->json();
    
        expect($return)->toHaveProperty('message', "Não autorizado!");
        expect($return)->toHaveProperty('type', false);
    });
});
