<?php

namespace App\Contracts\Repository;

interface PokemonRepositoryContract extends RepositoryContract
{
    public function setTypes(): bool;
}
