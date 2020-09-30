<?php

namespace MayIFit\Core\Permission\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use MayIFit\Core\Permission\Models\Permission;

class GeneratePermissionsCommand extends Command
{
    protected $signature = 'mayifit:gen-permissions';

    protected $description = 'Generates permissions based on the graphql schema';

    private $permissionMethodWhitelist = [
        'list',
        'view',
        'create',
        'update',
        'delete',
        'import',
        'impersonate'
    ];

    public function handle()
    {
        $this->info('Introspecting graphql schema...');

        $this->registerPermissions();

        $this->info('Permissions generated');
    }


    private function registerPermissions(): void
    {
        // Schema introspection
        $response = $this->graphQL('
            {
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
            }
        ');

        $queries = array_merge(
            $response['data']['__schema']['queryType']['fields'] ?? [],
            $response['data']['__schema']['mutationType']['fields'] ?? [],
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

            foreach ($this->permissionMethodWhitelist as $accepted) {
                if (strpos($method, $accepted) !== false) {
                    Permission::firstOrCreate(
                        [
                            'method' => $method,
                            'name' => $name,
                        ],
                        [
                            'controller' => 'graphql',
                            'base_controller' => 'graphql',
                            'method' => $method,
                            'name' => $name,
                            'middleware' => 'graphql'
                        ]
                    );
                    break;
                }
            }
        }
    }


    private function graphQL(string $query)
    {
        return Http::post(route(config('lighthouse.route.name')), [
            'query' => $query
        ])->throw()->json();
    }
}
