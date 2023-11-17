<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class InternalError extends HttpResponseException
{
    public function __construct(
        ?string $message
    ) {
        parent::__construct(
            response()->json([
                "message" => $message ?? "Erro interno do servidor!",
                "type" => false
            ], Response::HTTP_INTERNAL_SERVER_ERROR)
        );
    }
}
