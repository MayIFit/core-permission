<?php

namespace MayIFit\Core\Permission\Tests;

use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\SanctumServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Nuwave\Lighthouse\LighthouseServiceProvider;
use Nuwave\Lighthouse\WhereConditions\WhereConditionsServiceProvider;
use Nuwave\Lighthouse\OrderBy\OrderByServiceProvider;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

use MayIFit\Core\Translation\TranslationServiceProvider;
use MayIFit\Core\Permission\PermissionServiceProvider;
use MayIFit\Core\Permission\Tests\User;
use MayIFit\Core\Permission\Models\Permission;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MakesGraphQLRequests;

    private $permissionMethodWhitelist = [
        'list',
        'view',
        'create',
        'update',
        'delete',
        'import',
        'impersonate'
    ];

    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench'])->run();
        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->publishResources();
        $this->withFactories(__DIR__ . '../src/Database/Factories');
        $this->withFactories(__DIR__ . '/Factories');

        // As almost every model has a createdBy or updatedBy relation
        // it makes sense to create a mock user here, globally
        $user = factory(User::class)->create();
        Sanctum::actingAs($user, ['*']);

        Relation::morphMap([
            'user' => 'MayIFit\Core\Permission\Tests\User',
        ]);

        $this->artisan('db:seed', ['--database' => 'testbench', '--class' => 'MayIFit\\Core\\Permission\\Database\\Seeds\\DatabaseSeeder'])->run();
        $this->registerPermissions();
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SanctumServiceProvider::class,
            WhereConditionsServiceProvider::class,
            OrderByServiceProvider::class,
            LighthouseServiceProvider::class,
            TranslationServiceProvider::class,
            PermissionServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->push('lighthouse.namespaces.models', 'MayIFit\\Core\\Permission\\Tests');
    }

    protected function publishResources()
    {
        $this->artisan('vendor:publish', [
            '--provider' => LighthouseServiceProvider::class,
            '--force' => true
        ])->execute();

        $this->artisan('vendor:publish', [
            '--provider' => TranslationServiceProvider::class,
            '--tag' => 'schema',
            '--force' => true,
        ])->execute();

        $this->artisan('vendor:publish', [
            '--provider' => PermissionServiceProvider::class,
            '--tag' => 'schema',
            '--force' => true,
        ])->execute();

        file_put_contents(
            $this->app['config']->get('lighthouse.schema.register'),
            '
#import core/*.graphql
#import extensions/*.graphql

type User {
    id: ID!
    name: String
    email: String!
}

input CreateUserInput {
    name: String!
    email: String!
    password: String! @hash
}

input UpdateUserInput {
    id: ID!
    name: String
    email: String
    password: String @hash
}

type Query

type Mutation
        ',
            FILE_APPEND
        );
    }

    // Resets the applications auth state
    protected function resetAuth(array $guards = null)
    {
        $guards = $guards ?: array_keys(config('auth.guards'));

        foreach ($guards as $guard) {
            $guard = $this->app['auth']->guard($guard);

            if ($guard instanceof \Illuminate\Auth\SessionGuard) {
                $guard->logout();
            }
        }

        $protectedProperty = new \ReflectionProperty($this->app['auth'], 'guards');
        $protectedProperty->setAccessible(true);
        $protectedProperty->setValue($this->app['auth'], []);
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
        return $this->post(route(config('lighthouse.route.name')), [
            'query' => $query
        ])->json();
    }
}
