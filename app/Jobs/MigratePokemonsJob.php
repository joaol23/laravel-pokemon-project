<?php

namespace App\Jobs;

use App\Contracts\Services\PokemonMigrateServiceContract;
use App\Enum\LogsFolder;
use App\Utils\Logging\CustomLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MigratePokemonsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public int $tries = 2;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $page,
        private readonly int $limit
    ) {
        $this->onQueue("pokemon_migration");
    }

    /**
     * Execute the job.
     */
    public function handle(
        PokemonMigrateServiceContract $pokemonMigrateService
    ): int {
        CustomLogger::info(
            "Iniciando migração de pokemons da página {$this->page} com limite de {$this->limit}",
            LogsFolder::API_EXTERNAL_POKEMON
        );
        $pokemonMigrateService->migrate($this->page, $this->limit);
        CustomLogger::info(
            "Finalizando com sucesso migração de pokemons da página {$this->page} com limite de {$this->limit}",
            LogsFolder::API_EXTERNAL_POKEMON
        );
        return 1;
    }

    public function fail(\Throwable $exception): void
    {
        CustomLogger::error(
            "Erro ao processar fila de migração de pokemons.
            Erro => " . $exception->getMessage(),
            LogsFolder::API_EXTERNAL_POKEMON
        );
        throw $exception;
    }
}
