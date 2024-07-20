<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Middleware\AuthenticateSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check for bearer token
        if(!$request->bearerToken() || $request->bearerToken() === 'null' || $request->header('Authorization') === null){
            throw new AuthenticationException('Token Not Provided');
        }
        //header accept json
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
