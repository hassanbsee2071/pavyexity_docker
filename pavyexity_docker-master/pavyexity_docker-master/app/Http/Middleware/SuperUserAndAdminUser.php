<?php

namespace App\Http\Middleware;

use Closure;

class SuperUserAndAdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!(isSuperAdmin()||isAdmin())) {
            abort(403);
        }
        return $next($request);
    }
}
