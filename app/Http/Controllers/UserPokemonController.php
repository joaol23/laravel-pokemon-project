<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserPokemonServiceContract;
use App\Dto\UserPokemon\AddPokemonUserDto;
use App\Http\Requests\AddPokemonRequest;
use App\Http\Resources\PokemonCollectionResource;
use App\Http\Resources\PokemonUserCollectionResource;
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
        return $this->apiResponse(
            message: $created ? "Pokemon adicionado com sucesso!" : "Erro ao adicionar pokemon!",
            type: $created
        )
            ->response()
            ->setStatusCode($created ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function listPokemons(
        int $userId
    ): PokemonUserCollectionResource {
        return new PokemonUserCollectionResource(
            $this->userPokemonService->listPokemons($userId)
        );
    }

    public function removePokemon(
        int $userId,
        int $order
    ): JsonResponse {
        $removed = $this->userPokemonService
            ->removePokemonInOrder($userId, $order);

        return $this->apiResponse(
            message: $removed ? "Pokemon removido com sucesso!" : "Sem pokemon nessa posição!",
            type: $removed,
        )
            ->response()
            ->setStatusCode($removed ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
