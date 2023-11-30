<?php

namespace App\Exceptions\Clients\Requests;

class ParameterNotSet extends \Exception
{
    public function __construct(
        string $parameter
    )
    {
        parent::__construct(
            "Parametro não setado para requisição {$parameter}",
            400
        );
    }
}
