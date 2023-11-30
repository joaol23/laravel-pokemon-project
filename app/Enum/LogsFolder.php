<?php

namespace App\Enum;

Enum LogsFolder: string
{
    case USERS = 'users';
    case AUTH = 'auth';
    case API_EXTERNAL_POKEMON = 'external/pokemons';

    case POKEMON = 'pokemons';

    case POKEMON_TYPES = 'pokemons_types';
}
