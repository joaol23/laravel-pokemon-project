<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserPokemonServiceContract;
use App\Dto\UserPokemon\AddPokemonUserDto;
use App\Http\Requests\AddPokemonRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserPokemonController extends Controller
{
    public function __construct(
        private readonly UserPokemonServiceContract $userPokemonService
    ) {
    }

    public function addPokemon(
        int $userId,
        int $pokemonId,
        AddPokemonRequest $request
    ): JsonResponse {
        $addPokemonDto = new AddPokemonUserDto(
            $request->get('order'),
            $userId,
            $pokemonId
        );
        return response()->json(
            [
                "type"    =>
                    $this->userPokemonService
                        ->addPokemon($addPokemonDto),
                "message" => "Pokemon adicionado com sucesso!"
            ],
            Response::HTTP_CREATED
        );
    }

    public function listPokemons(
        int $userId
    ): JsonResponse {
        return response()->json(
            [
                "data" => $this->userPokemonService->listPokemons($userId),
            ]
        );
    }

    public function removePokemon(
        int $userId,
        int $order
    ): JsonResponse {
        $removed = $this->userPokemonService
            ->removePokemonInOrder($userId, $order);
        return response()->json(
            [
                "type"    => $removed,
                "message" => $removed ? "Pokemon removido com sucesso!" : "Sem pokemon nessa posição!",
            ], $removed ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
