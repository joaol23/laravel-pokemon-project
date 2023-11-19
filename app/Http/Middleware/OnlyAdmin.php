<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        /** @var User */
        $user = auth("sanctum")->user();

        if (!$user->isAdmin()) {
            throw new UnauthorizedException(
                "Não autorizado!",
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
