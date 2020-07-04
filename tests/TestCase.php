<?php

namespace MayIFit\Core\Permission\Tests;

use Laravel\Sanctum\SanctumServiceProvider;
use Nuwave\Lighthouse\LighthouseServiceProvider;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

use MayIFit\Core\Permission\PermissionServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MakesGraphQLRequests;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->publishResources();
        $this->artisan('migrate', ['--database' => 'testbench'])->execute();
    }

    protected function getPackageProviders($app)
    {
        return [
            SanctumServiceProvider::class,
            LighthouseServiceProvider::class,
            PermissionServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('lighthouse.namespaces.models', 'Illuminate\\Foundation\\Auth');
    }

    protected function publishResources() {
        $this->artisan('vendor:publish', [
            '--provider' => 'Nuwave\\Lighthouse\\LighthouseServiceProvider',
            '--tag' => 'schema'
        ])->execute();

        $this->artisan('vendor:publish', [
            '--provider' => 'Nuwave\\Lighthouse\\LighthouseServiceProvider',
            '--tag' => 'config'
        ])->execute();

        $this->artisan('vendor:publish', [
            '--provider' => 'MayIFit\\Core\\Permission\\PermissionServiceProvider',
            '--force' => 'true'
        ])->run();

        file_put_contents($this->app['config']->get('lighthouse.schema.register'), 
        '
#import core/*.graphql
#import extensions/*.graphql

type Query

type Mutation
        ');
    }
}