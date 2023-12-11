<?php

namespace App\Exceptions\Auth;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationCredentialsInvalid extends HttpResponseException
{
    public function __construct()
    {
        parent::__construct(
            response()->json([
                "message" => "Credenciais inválidas!",
                "type"    => false
            ], Response::HTTP_UNAUTHORIZED)
        );
    }
}
