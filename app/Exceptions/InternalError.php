<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InternalError extends Exception
{
    public function __construct(
        ?string $message
    ) {
        parent::__construct(
            $message ?? "Erro interno.",
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
