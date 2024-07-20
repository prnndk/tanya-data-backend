<?php

namespace App\Http\Middleware;

use App\Enums\RoleType;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role !== RoleType::ADMIN && User::where('id', auth()->id())->firstOrFail()->role !== RoleType::ADMIN){
            return response()->json([
                'success' => false,
                'message' => 'Invalid Access'
            ], 403);
        }
        return $next($request);
    }
}
