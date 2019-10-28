<?php

namespace App\Http\Middleware;


use Closure;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
        $permissions = explode('|', $permission);

        foreach ($permissions as $per) {
            if (auth()->user()->hasPermission($per)) {
                return $next($request);
            }
        }
        abort(403, 'شما اجازه دسترسی به این صفحه را ندارید');

    }
}
