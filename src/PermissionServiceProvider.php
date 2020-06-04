<?php
    namespace MayIFit\Core\Permission;

    use Illuminate\Console\Events\CommandFinished;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Event;
    use Illuminate\Support\Facades\Request;
    use Illuminate\Contracts\Cache\Factory;
    use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\Str;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Symfony\Component\Console\Output\ConsoleOutput;
    
    use MayIFit\Core\Permission\Models\Permission;
    use MayIFit\Core\Permission\Models\Role;
    use MayIFit\Core\Permission\Models\User;
    use MayIFit\Core\Permission\Models\SystemSetting;
    use MayIFit\Core\Permission\Policies\PermissionPolicy;
    use MayIFit\Core\Permission\Policies\RolePolicy;
    use MayIFit\Core\Permission\Policies\UserPolicy;
    use MayIFit\Core\Permission\Policies\SystemSettingPolicy;

    class PermissionServiceProvider extends ServiceProvider {

        /**
         * The policy mappings for the application.
         *
         * @var array
         */
        protected $policies = [
            Permission::class => PermissionPolicy::class,
            Role::class => RolePolicy::class,
            User::class => UserPolicy::class,
            SystemSetting::class => SystemSettingPolicy::class
        ];

        /**
         * The seed folder for the package.
         *
         * @var array
         */
        protected $database_folder = '/Database';

        public function boot(Factory $cache, SystemSetting $settings) {
            Relation::morphMap([
                'user' => 'MayIFit\Core\Permission\Models\User',
            ]);

            $this->loadMigrationsFrom(__DIR__.$this->database_folder.'/migrations');
            if ($this->app->runningInConsole()) {
                if ($this->isConsoleCommandContains([ 'db:seed', '--seed' ], [ '--class', 'help', '-h' ])) {
                    $this->addSeedsAfterConsoleCommandFinished();
                }
            }

            $settings = $cache->remember('system_settings', 60, function() use ($settings) {
                return $settings->pluck('setting_value', 'setting_name')->all();
            });
            config()->set('settings', $settings);
            
            $this->publishResources();
            $this->registerPolicies();
        }

        public function register() {
            $this->app->bind('permission', function () {
                return new Permission();
            });
            $this->app->bind('role', function () {
                return new Role();
            });
        }

        /**
         * Publish resources
         *
         * @return void
         */
        protected function publishResources() {
            $this->publishes([
                __DIR__.'/GraphQL/schema' => './graphql/core',
            ]);
            $this->publishes([
                __DIR__.'/GraphQL/Mutations' => './app/GraphQL/Mutations/Core',
            ]);
            $this->publishes([
                __DIR__.'/GraphQL/Queries' => './app/GraphQL/Queries/Core',
            ]);
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
        protected function isConsoleCommandContains($contain_options, $exclude_options = null) : bool {
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
        protected function addSeedsAfterConsoleCommandFinished() {
            Event::listen(CommandFinished::class, function(CommandFinished $event) {
                // Accept command in console only,
                // exclude all commands from Artisan::call() method.
                if ($event->output instanceof ConsoleOutput) {
                    Artisan::call('db:seed', [ '--class' => "MayIFit\Core\Permission\Database\Seeds\DatabaseSeeder", '--force' => '' ]);
                }
            });
        }
    }
?>