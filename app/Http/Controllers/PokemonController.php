<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PokemonServiceContract;
use Illuminate\Http\JsonResponse;

class PokemonController extends Controller
{

    public function __construct(
        private readonly PokemonServiceContract $pokemonService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->pokemonService
                ->listAll()
        );
    }
}
