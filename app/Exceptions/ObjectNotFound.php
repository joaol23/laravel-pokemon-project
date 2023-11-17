<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ObjectNotFound extends HttpResponseException
{
    public function __construct(string $object)
    {
        parent::__construct(
            response()->json(
                [
                    "message" =>
                    "{$object} não encontrado!",
                    "type" => false
                ],
                Response::HTTP_NOT_FOUND
            )
        );
    }
}
