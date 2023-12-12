<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserPokemonServiceContract;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserPokemonController extends Controller
{
    public function __construct(
        private readonly UserPokemonServiceContract $userPokemonService
    ) {
    }

    public function addPokemon(
        int $userId, int $pokemonId
    ): JsonResponse {
        return response()->json([
            "type"    => $this->userPokemonService
                ->addPokemon($userId, $pokemonId),
            "message" => "Pokemon adicionado com sucesso!"
        ], Response::HTTP_CREATED);
    }

    public function listPokemons(
        int $userId
    ): JsonResponse {
        return response()->json([
            "data" => $this->userPokemonService->listPokemons($userId),
        ]);
    }
}
