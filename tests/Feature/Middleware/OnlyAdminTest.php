<?php


use App\Enum\RolesUser;
use App\Http\Middleware\OnlyAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

describe("Testando o middleware de so permitir usuarios admin", function () {
    beforeEach(function () {
        $this->userNormal = User::factory(User::class)
            ->createOne();
        $this->userAdmin = User::factory(User::class)
            ->createOne(['role' => RolesUser::ADMIN->value]);
    });

    test("Testando com usuário admin, sucesso", function () {
        $this->actingAs($this->userAdmin);

        $request = new Request();
        $middleware = new OnlyAdmin();
        $response = $middleware->handle($request, function () {
            return response()->json(['message' => 'ok']);
        });

        expect($response->getStatusCode())->toBe(200);
        expect($response->getContent())->toBe('{"message":"ok"}');
    });

    test("Testando com usuário normal, falha", function () {
        $this->actingAs($this->userNormal);

        $request = new Request();
        $middleware = new OnlyAdmin();
        $response = $middleware->handle($request, function () {
            return response()->json(['message' => 'ok']);
        });
    })->throws(
        UnauthorizedException::class,
        "Não autorizado!",
        401
    );
});
