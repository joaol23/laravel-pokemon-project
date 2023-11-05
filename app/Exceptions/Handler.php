<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $dontReport = [
        JsonValidationExceptionHandling::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
{
    if ($exception instanceof ValidationException) {
        return response()->json([
            'message' => 'Dados inválidos',
            'errors' => $exception->errors(),
        ], 422);
    }

    return response()->json([
        'message' => $exception->getMessage(),
        'type' => false,
    ], $exception->getCode());
}
}
