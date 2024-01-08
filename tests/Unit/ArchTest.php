<?php

arch('Sem debugs no projeto')
    ->expect(['dd', 'dump', 'var_dump', 'die'])
    ->not->toBeUsed();

arch('Enums')
    ->expect('App\Enum')
    ->toBeEnums();

arch('Contracts')
    ->expect('App\Contracts')
    ->toBeInterfaces();

arch('models')
    ->todo()
    ->expect('App\Models')
    ->toOnlyBeUsedIn('App\Repositories')
    ->ignoring('Database\\');

arch('app')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');
