<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

use MayIFit\Core\Permission\Models\Permission;
use MayIFit\Core\Permission\Models\Role;

/**
 * Class PermissionTableSeeder
 *
 * @package MayIFit\Core\Permission
 */
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        // Schema introspection
        $response = $this->graphql("{ 
            __schema {
                queryType {
                    name
                    fields {
                        name
                    }
               }
               mutationType {
                    name
                    fields {
                        name
                    }
               }
            }
        }");
        
        $queries = array_merge(
            $response['data']['__schema']['queryType']['fields'],
            $response['data']['__schema']['mutationType']['fields'],
        );
        foreach ($queries as $query) {
            $split = preg_split('/(?=[A-Z])/', $query['name']);
            if (!\is_array($split) || count($split) <= 1) {
                continue;
            }
            $method = strtolower($split[0]);
            if ($method === 'list') {
                $method = 'index';
            }
            $name = strtolower($split[1]);
            $checkDuplicatePermission = Permission::where(
                ['name'=> $name, 'method' => $method]
            )->first();
            if (!$checkDuplicatePermission) {
                $permission = new Permission;
                $permission->controller = 'graphql';
                $permission->base_controller = 'graphql';
                $permission->method = $method;
                $permission->name =  $name;
                $permission->middleware = 'graphql';
                $permission->save();
            }
        }
    }

    protected function graphql(string $query) {
        return Http::post(\Config::get('app.url').'/api/v1/graphql', [
            'query' => $query
        ])->throw()->json();
    }
}
