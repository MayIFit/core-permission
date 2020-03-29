<?php

namespace MayIFit\Core\Permission\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Models\Permission;

class PermissionMiddleware
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
        if (Auth::guard('api')->check() || Auth::user()) {
            $user = $request->user() ?? Auth::user();
            // get user role permissions
            $roles = $user->roles()->get();
            foreach ($roles as $key => $role) {
                $permissions = $role->permissions()->get();
                // get requested action
                
                $actionName = class_basename($request->route()->getActionname());
                // check if requested action is in permissions list
                foreach ($permissions as $permission) {
                    $_namespaces_chunks = explode('\\', $permission->controller);
                    $controller = end($_namespaces_chunks);
                    if ($actionName == $controller . '@' . $permission->method) {
                        // authorized request
                        return $next($request);
                    }
                }
            }
        }

        // none authorized request
        return response()->json(['error' => 'Unauthorized.'], 403);
    }
}
