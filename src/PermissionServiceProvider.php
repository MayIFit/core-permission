<?php

namespace MayIFit\Core\Permission;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\Relation;
use Symfony\Component\Console\Output\ConsoleOutput;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Models\Document;
use MayIFit\Core\Permission\Models\Permission;
use MayIFit\Core\Permission\Models\SystemSetting;
use MayIFit\Core\Permission\Policies\RolePolicy;
use MayIFit\Core\Permission\Policies\PermissionPolicy;
use MayIFit\Core\Permission\Policies\SystemSettingPolicy;
use MayIFit\Core\Permission\Observers\RoleObserver;
use MayIFit\Core\Permission\Observers\DocumentObserver;
use MayIFit\Core\Permission\Observers\SystemSettingObserver;

class PermissionServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        SystemSetting::class => SystemSettingPolicy::class
    ];

    /**
     * The seed folder for the package.
     *
     * @var array
     */
    protected $database_folder = '/Database';

    public function boot(Factory $cache, SystemSetting $settings, ConfigRepository $configRepository)
    {
        Relation::morphMap([
            'user' => 'App\Models\User',
        ]);
        $this->mergeConfigFrom(__DIR__ . '/core-permission.php', 'core-permission');
        $this->publishResources($configRepository);

        $this->loadMigrationsFrom(__DIR__ . $this->database_folder . '/migrations');
        if ($this->app->runningInConsole()) {
            if ($this->isConsoleCommandContains(['db:seed', '--seed'], ['--class', 'help', '-h'])) {
                $this->addSeedsAfterConsoleCommandFinished();
            }
        }

        $this->registerPolicies();
        $this->registerObservers();
    }

    /**
     * Publish resources
     *
     * @return void
     */
    protected function publishResources(ConfigRepository $configRepository): void
    {
        $this->publishes([
            __DIR__ . '/core-permission.php' => $this->app->configPath() . '/core-permission.php',
        ], 'config');

        $this->publishes([
            __DIR__ . '/GraphQL/schema' => $configRepository->get('core-permission.schema.register'),
        ], 'schema');

        $this->publishes([
            __DIR__ . '/GraphQL/Queries' => $configRepository->get('core-permission.queries.register'),
        ], 'graphql');

        $this->publishes([
            __DIR__ . '/GraphQL/Mutations' => $configRepository->get('core-permission.mutations.register'),
        ], 'graphql');

        $this->publishes([
            __DIR__ . '/GraphQL/Scalars' => $configRepository->get('core-permission.scalars.register'),
        ], 'graphql');
    }

    /**
     * Get a value that indicates whether the current command in console
     * contains a string in the specified $fields.
     *
     * @param string|array $contain_options
     * @param string|array $exclude_options
     *
     * @return bool
     */
    protected function isConsoleCommandContains($contain_options, $exclude_options = null): bool
    {
        $args = Request::server('argv', null);
        if (is_array($args)) {
            $command = implode(' ', $args);
            if (Str::contains($command, $contain_options) && ($exclude_options == null || !Str::contains($command, $exclude_options))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Add seeds from the $seed_path after the current command in console finished.
     */
    protected function addSeedsAfterConsoleCommandFinished()
    {
        Event::listen(CommandFinished::class, function (CommandFinished $event) {
            // Accept command in console only,
            // exclude all commands from Artisan::call() method.
            if ($event->output instanceof ConsoleOutput) {
                Artisan::call('db:seed', ['--class' => "MayIFit\Core\Permission\Database\Seeds\DatabaseSeeder", '--force' => '']);
            }
        });
    }

    /**
     * Register model observers.
     *
     * @return void
     */
    private function registerObservers(): void
    {
        Document::observe(DocumentObserver::class);
        Role::observe(RoleObserver::class);
        SystemSetting::observe(SystemSettingObserver::class);
    }
}
