<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PokemonExternalServiceContract;
use App\Contracts\Services\PokemonServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PokemonController extends Controller
{

    public function __construct(
        private readonly PokemonServiceContract $pokemonService,
        private readonly PokemonExternalServiceContract $pokemonExternalService
    ) {
    }

    public function index(
        Request $request
    ): JsonResponse {
        $searchParam = $request->query('q');
        if ($searchParam) {
            return response()->json(
                $this->pokemonService
                    ->search($searchParam)
            );
        }
        return response()->json(
            $this->pokemonService
                ->listAll()
        );
    }

    public function details(string $name): JsonResponse
    {
        return response()->json(
            [
                "data" => $this->pokemonExternalService->getPokemon($name)
            ]
        );
    }
}
