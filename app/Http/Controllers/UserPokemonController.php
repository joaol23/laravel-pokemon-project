<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserPokemonServiceContract;
use Symfony\Component\HttpFoundation\Response;

class UserPokemonController extends Controller
{
    public function __construct(
        private readonly UserPokemonServiceContract $userService
    ) {
    }

    public function addPokemon(
        int $userId, int $pokemonId
    ): \Illuminate\Http\JsonResponse {
        return response()->json([
            "type" => $this->userService
                ->addPokemon($userId, $pokemonId),
            "message" => "Pokemon adicionado com sucesso!"
        ], Response::HTTP_CREATED);
    }
}
