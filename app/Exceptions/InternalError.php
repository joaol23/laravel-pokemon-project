<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InternalError extends HttpResponseException
{
    public function __construct(
        ?string $message
    ) {
        $this->message = $message ?? "Erro interno do servidor!";
        parent::__construct(
            response()->json([
                "message" => $this->message,
                "type" => false
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR)
        );
    }
}
