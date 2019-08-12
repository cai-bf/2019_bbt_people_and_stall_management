<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Models\Permission;

class PermissionAuth
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
        $route = $request->route()->getName();
        if (Permission::where('route', $route)->first()) {
            $user = auth()->user();
            $permissions = $user->getPermissionsViaRoles();
            if ($permissions->where('route', $route)->isEmpty()) {
                return response()->json([
                    'message' => '权限不足',
                    'status_code' => 401
                ], 401);
            }
        }

        return $next($request);
    }
}
