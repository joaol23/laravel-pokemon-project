<?php

namespace App\Http\Controllers;

use App\Http\Resources\Default\ApiResponseResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function apiResponse(
        mixed $resource = [],
        ?string $message = null,
        bool $type = true
    ): ApiResponseResource {
        return new ApiResponseResource(
            $resource,
            $message,
            $type
        );
    }
}
