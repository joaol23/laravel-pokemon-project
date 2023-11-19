<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ObjectNotFound extends HttpResponseException
{
    public function __construct(string $object)
    {
        $this->message = "{$object} não encontrado!";
        parent::__construct(
            response()->json([
                "message" => $this->message,
                "type" => false
            ], Response::HTTP_NOT_FOUND)
        );
    }
}
