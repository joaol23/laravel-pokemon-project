<?php

namespace App\Exceptions;

use Exception;

class ObjectNotFound extends Exception
{
    public function __construct(string $object)
    {
        parent::__construct(
            "{$object} não encontrado!",
            404
        );
    }
}
