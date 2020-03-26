<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;

use MayIFit\Core\Permission\Models\Permission;
use MayIFit\Core\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
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
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_ids = array();
        // iterate though all routes
        foreach (\Route::getRoutes()->getRoutes() as $key => $route) {
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

            $name = '';
            if (isset($this->methodMap[$method])) {
                $explodedRouteName = explode('.', $route->getName());
                if (count($explodedRouteName) > 1) array_pop($explodedRouteName);
                $routeName = implode('.', $explodedRouteName) ?? $route->getName();
                $name = $routeName.'.'.$this->methodMap[$method];
            }

            if (!$permission_check) {
                $permission = new Permission;
                $permission->controller = $controller;
                $permission->method = $method;
                $permission->name =  $name;
                $permission->middleware = implode('|', $route->middleware());
                $permission->save();
                // add stored permission id in array
                $permission_ids[] = $permission->id;
            }
        }
        // find admin role.
        $admin_role = Role::where('name', 'admin')->firstOrFail();
        // attach all permissions to admin role
        $admin_role->permissions()->attach($permission_ids);
    }
}
