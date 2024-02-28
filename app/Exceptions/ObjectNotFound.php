<?php

namespace App\Exceptions;

use App\Http\Resources\Default\ApiResponseResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ObjectNotFound extends HttpResponseException
{
    public function __construct(?string $object = null)
    {
        $this->message = ($object ?? "Objeto") . " não encontrado!";
        parent::__construct((
        new ApiResponseResource(message: $this->message,
            type: false
        ))
            ->response()
            ->setStatusCode(Response::HTTP_NOT_FOUND)
        );
    }
}
