<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PokemonExternalServiceContract;
use App\Contracts\Services\PokemonServiceContract;
use Illuminate\Http\JsonResponse;

class PokemonController extends Controller
{

    public function __construct(
        private readonly PokemonServiceContract $pokemonService,
        private readonly PokemonExternalServiceContract $pokemonExternalService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->pokemonService
                ->listAll()
        );
    }

    public function details(string $name): JsonResponse
    {
        return response()->json([
            "data" => $this->pokemonExternalService->getPokemon($name)
        ]);
    }
}
