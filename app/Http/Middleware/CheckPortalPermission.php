<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPortalPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $portal, string $permission): Response
    {
        if (! $request->user() || ! $request->user()->hasPermissionToInPortal($permission, $portal)) {
            abort(403, 'Unauthorized access to this portal.');
        }

        return $next($request);
    }
}
