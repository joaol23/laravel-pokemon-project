<?php

namespace App\Clients\Pokemon\PokeApi\Interfaces;

use Illuminate\Http\Client\PendingRequest;

interface ApiServiceInterface
{
    public function api(): PendingRequest;
}
