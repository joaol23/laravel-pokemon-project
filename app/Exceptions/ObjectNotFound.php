<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ObjectNotFound extends HttpResponseException
{
    public function __construct(?string $object = null)
    {
        $this->message = ($object ?? "Objeto") . " não encontrado!";
        parent::__construct(
            response()->json(   [
                                 "message" => $this->message,
                                 "type"    => false
                             ], Response::HTTP_NOT_FOUND)
        );
    }
}
