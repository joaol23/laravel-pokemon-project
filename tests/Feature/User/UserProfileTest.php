<?php

use App\Enum\RolesUser;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;

describe("Testando rota de perfil do usuário", function () {
    beforeEach(function () {
        $this->userNormal = User::factory(User::class)
            ->createOne();
        $this->userAdmin = User::factory(User::class)
            ->createOne([
                'role' => RolesUser::ADMIN->value
            ]);
        Storage::fake('public');
    });

    test("Salvando imagem corretamente, sucesso", function () {
        $return = (object)actingAs($this->userNormal)
            ->post(
                route('user.photo', $this->userNormal->getKey()),
                [
                    "photo" => UploadedFile::fake()
                        ->image('avatar.jpg')
                ]
            )
            ->assertStatus(200)
            ->json();

        Storage::disk('public')
            ->assertExists(str_replace('/storage', '', $return->data['path']));

        expect($return->type)
            ->toBeTrue()
            ->and($return->message)
            ->toBe("Imagem salva com sucesso!");

        expect($return->data)->toHaveKey("path");
    });

    test("Salvando imagem em outro usuário, erro", function () {
        $return = (object)actingAs($this->userNormal)
            ->post(
                route('user.photo', $this->userAdmin->getKey()),
                [
                    "photo" => UploadedFile::fake()
                        ->image('avatar.jpg')
                ]
            )
            ->assertStatus(401)
            ->json();

        expect($return)->toHaveProperty("message", "Não autorizado!");
        expect($return)->toHaveProperty("type", false);
    });
});
