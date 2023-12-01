<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class OnlyChangeCurrentUser
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
        $userLoggedIn = auth("sanctum")->user();
        $userRouteId = $request->route()->user;

        if (
            !($userLoggedIn->id === (int) $userRouteId) && !$userLoggedIn->isAdmin()
        ) {
            throw new UnauthorizedException(
                "Não autorizado!",
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
