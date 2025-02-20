<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponse; 

class CheckIfAdmin
{
    use ApiResponse; 
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->fonction !== 'ADMIN') {
            return $this->error('Unauthorized: Vous n’etes pas un administrateur', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
