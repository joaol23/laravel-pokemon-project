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
        $created = $this->userPokemonService
            ->addPokemon($addPokemonDto);
        return response()->json(
            [
                "message" => $created ? "Pokemon adicionado com sucesso!" : "Erro ao adicionar pokemon!",
                "type"    => $created,
            ],
            $created ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
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
                "message" => $removed ? "Pokemon removido com sucesso!" : "Sem pokemon nessa posição!",
                "type"    => $removed,
            ], $removed ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
