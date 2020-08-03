<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

use MayIFit\Core\Permission\Models\Permission;
use MayIFit\Core\Permission\Models\Role;

/**
 * Class PermissionsTableSeeder
 *
 * @package MayIFit\Core\Permission
 */
class PermissionsTableSeeder extends Seeder
{

    protected $whitelist = [
        'list',
        'view',
        'create',
        'update',
        'delete',
        'import',
        'impersonate'
    ];

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
            if (!is_array($split) || count($split) <= 1) {
                continue;
            }
            $method = strtolower(array_shift($split));
            $name = strtolower(implode('-', $split));
            if ($method === 'all') {
                $method = 'list';
            }

            foreach ($this->whitelist as $accepted) {
                if (strpos($method, $accepted) !== false) {
                    Permission::firstOrCreate([
                        'controller' => 'graphql',
                        'base_controller' => 'graphql',
                        'method' => $method,
                        'name' => $name,
                        'middleware' => 'graphql'
                    ]);
                    break;
                }
            }
        }
    }

    protected function graphql(string $query) {
        return Http::post(rtrim(config('app.url'), '/').'/api/v1/graphql', [
            'query' => $query
        ])->throw()->json();
    }
}
