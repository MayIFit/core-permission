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
            $split = preg_split('/(?=[A-Z])/', $query['name'], 2);
            if (!\is_array($split) || count($split) <= 1) {
                continue;
            }
            $method = strtolower($split[0]);
            $name = strtolower($split[1]);
            if ($method === 'all') {
                $method = 'list';
            }
            
            Permission::firstOrCreate([
                'controller' => 'graphql',
                'base_controller' => 'graphql',
                'method' => $method,
                'name' => $name,
                'middleware' => 'graphql'
            ]);
        }
    }

    protected function graphql(string $query) {
        return Http::post(rtrim(config('app.url'), '/').'/api/v1/graphql', [
            'query' => $query
        ])->throw()->json();
    }
}
