<?php

use App\Enum\RolesUser;
use App\Http\Middleware\OnlyChangeCurrentUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Validation\UnauthorizedException;

function getRequest(User $user): Request
{
    $request = new Request([], [], [], [], [], ['REQUEST_URI' => 'testing/' . $user->id]);

    $request->setRouteResolver(function () use ($request) {
        return (new Route('GET', 'testing/{user}', []))->bind($request);
    });
    return $request;
}

describe("Testando o middleware de so permitir modificar próprio usuario", function () {
    beforeEach(function () {
        $this->userNormalA = User::factory(User::class)
            ->createOne();
        $this->userNormalB = User::factory(User::class)
            ->createOne();
        $this->userAdmin = User::factory(User::class)
            ->createOne(['role' => RolesUser::ADMIN->value]);
    });

    test("Testando com usuario igual, sucesso", function () {
        $this->actingAs($this->userNormalA);

        $request = getRequest($this->userNormalA);

        $middleware = new OnlyChangeCurrentUser();
        $response = $middleware->handle($request, function () {
            return response()->json(['message' => 'ok']);
        });

        expect($response->getStatusCode())->toBe(200);
        expect($response->getContent())->toBe('{"message":"ok"}');
    });

    test("Testando com usuário diferente, falha", function () {
        $this->actingAs($this->userNormalA);

        $request = getRequest($this->userNormalB);

        $middleware = new OnlyChangeCurrentUser();
        $middleware->handle($request, function () {
            return response()->json(['message' => 'ok']);
        });
    })
        ->throws(
            UnauthorizedException::class,
            "Não autorizado!",
            401
        );

    test("Testando com usuário admin pode alterar qualquer um, sucess", function () {
        $this->actingAs($this->userAdmin);

        $request = getRequest($this->userNormalB);

        $middleware = new OnlyChangeCurrentUser();
        $response = $middleware->handle($request, function () {
            return response()->json(['message' => 'ok']);
        });

        expect($response->getStatusCode())->toBe(200);
        expect($response->getContent())->toBe('{"message":"ok"}');
    });
});
