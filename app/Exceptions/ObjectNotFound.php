<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ObjectNotFound extends Exception
{
    public function __construct(string $object)
    {
        parent::__construct(
            "{$object} não encontrado!",
            Response::HTTP_NOT_FOUND
        );
    }
}
