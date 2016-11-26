<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Auth\AuthenticationException;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $role
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role)) {
            throw new AuthenticationException("Not $role");
        }

        return $next($request);
    }
}
