<?php

use App\Models\Pokemon\Pokemon;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

describe("Testando fluxo de adicionar pokemon à um usuário", function () {
    beforeEach(function () {
        $this->user = User::factory()
            ->create();
        $this->pokemon = Pokemon::factory()
            ->create();
    });

    test("Pokemon sendo adicionado a um usuario logado, sucesso", function () {
        $response = $this->actingAs($this->user)
            ->post(route("user.add.pokemon", [
                $this->user->id,
                $this->pokemon->id
            ]))
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                "type"=> true,
                "message" => "Pokemon adicionado com sucesso!"
            ]);

        $this->assertDatabaseHas("users_pokemons", [
            "user_id"    => $this->user->id,
            "pokemon_id" => $this->pokemon->id
        ]);

        expect($this->user->pokemons()
            ->get())->toHaveCount(1);
    });

    test("Pokemon sendo adicionado a um usuario não logado, erro", function () {
        $response = $this->post(route("user.add.pokemon", [
                $this->user->id,
                $this->pokemon->id
            ]))
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                "type"=> false,
                "message" => "Não autorizado!"
            ]);

        $this->assertDatabaseMissing("users_pokemons", [
            "user_id"    => $this->user->id,
            "pokemon_id" => $this->pokemon->id
        ]);

        expect($this->user->pokemons()
            ->get())->toHaveCount(0);
    });

    test("Pokemon sendo adicionado a um usuario logado, mas pokemon não existe, erro", function () {
        $response = $this->actingAs($this->user)
            ->post(route("user.add.pokemon", [
                $this->user->id,
                412412]))
        ->assertStatus(400)
        ->assertJson([
            "type"=> false,
            "message" => "Error ao selecionar pokemon!"
        ]);
    });

    test("Pokemon sendo adicionado a um usuario logado, mas pokemon já adicionado, não adicionar", function () {
        $this->user->pokemons()
            ->attach($this->pokemon->id);

        $response = $this->actingAs($this->user)
            ->post(route("user.add.pokemon", [
                $this->user->id,
                $this->pokemon->id
            ]))
            ->assertStatus(201)
            ->assertJson([
                "type"=> true,
                "message" => "Pokemon adicionado com sucesso!"
            ]);

        expect($this->user->pokemons()->get())->toHaveCount(1);
    });

    test("Usuario tentando adicionar em outro usuario, erro", function () {
        $user2 = User::factory()
            ->create();

        $response = $this->actingAs($user2)
            ->post(route("user.add.pokemon", [
                $this->user->id,
                $this->pokemon->id
            ]))
            ->assertStatus(401)
            ->assertJson([
                "type"=> false,
                "message" => "Não autorizado!"
            ]);

        expect($this->user->pokemons()->get())->toHaveCount(0);
    });
});
