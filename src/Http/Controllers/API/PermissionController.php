<?php

namespace MayIFit\Core\Permissions\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use MayIFit\Core\Permissions\Models\Permission;
use MayIFit\Core\Permissions\Models\Role;

class PermissionController extends Controller
{

    private $methodMap = [
        'index' => 'browse',
        'show' => 'view',
        'edit' => 'view-edit-screen',
        'update' => 'edit',
        'create' => 'view-create-screen',
        'store' => 'create',
        'destroy' => 'delete',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->refreshPermissions(), 200);
    }

    
    /**
     * Creates Permissions based on routes and Controllers.
     *
     * @return \MayIFit\Core\Permissions\Models\Permission[]
     */
    protected function refreshPermissions() {
        $permission_ids = [];
        $permissions = [];
        // iterate though all routes
        foreach (Route::getRoutes()->getRoutes() as $key => $route) {
            // get route action
            $action = $route->getActionname();
            // separating controller and method
            $_action = explode('@', $action);
            $controller = $_action[0];
            $method = end($_action);
            
            // check if this permission is already exists
            $permission_check = Permission::where(
                ['controller'=> $controller, 'method' => $method]
            )->first();
            if ($permission_check) {
                continue;
            }

            $name = '';
            if (isset($this->methodMap[$method])) {
                $explodedRouteName = explode('.', $route->getName());
                if (count($explodedRouteName) > 1) array_pop($explodedRouteName);
                $routeName = implode('.', $explodedRouteName) ?? $route->getName();
                $name = $routeName.'.'.$this->methodMap[$method];
            }
            
            $permission = new Permission;
            $permission->controller = $controller;
            $permission->method = $method;
            $permission->name =  $name;
            $permission->middleware = implode('|', $route->middleware());
            $permission->save();
            // add stored permission id in array
            $permission_ids[] = $permission->id;
            $permissions[] = $permission;
        }
        // find admin role.
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->attach($permission_ids);
        }
        // attach all permissions to admin role
        return $permissions;
    }

}