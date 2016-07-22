<?php

namespace App\Http\Middleware;

use Closure;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!$request->user() || request()->user()->role->hasPermission($permission)) {
            return $next($request);
        }
        return abort(403, 'Unauthorized action');
    }
}
