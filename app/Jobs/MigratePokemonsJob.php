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


    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $page,
        private readonly int $limit
    )
    {
        $this->onQueue("pokemon_migration");
    }

    /**
     * Execute the job.
     */
    public function handle(PokemonMigrateServiceContract $pokemonMigrateService): void
    {
        $pokemonMigrateService->migrate($this->page, $this->limit);
    }

    public function fail(\Throwable $exception): void
    {
        CustomLogger::error(
            "Erro ao processar fila de migração de pokemons. Erro => " . $exception->getMessage(),
            LogsFolder::API_EXTERNAL_POKEMON
        );
    }
}
