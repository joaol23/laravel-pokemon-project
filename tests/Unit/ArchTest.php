<?php

test('Sem debugs no projeto')
    ->only()
    ->expect(['dd', 'dump', 'var_dump', 'die'])
    ->not->toBeUsed();

