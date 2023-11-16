<?php

namespace App\Exceptions;

use Exception;

class InternalError extends Exception
{
    public function __construct(
        ?string $message
    ) {
        parent::__construct(
            $message ?? "Erro interno.",
            500
        );
    }
}
