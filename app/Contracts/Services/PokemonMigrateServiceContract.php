<?php

namespace App\Contracts\Services;

interface PokemonMigrateServiceContract
{
    public function migrate(int $page, int $limit): void;
}
