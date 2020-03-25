<?php
    namespace MayIFit\Permissions;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Gate;

    use MayIFit\Permissions\Models\Permission;
    use MayIFit\Permissions\Policies\PermissionPolicy;

    class PermissionsServiceProvider extends ServiceProvider {

        /**
         * The policy mappings for the application.
         *
         * @var array
         */
        protected $policies = [
            Permission::class => PermissionPolicy::class,
        ];

        public function boot(\Illuminate\Routing\Router $router, \Illuminate\Contracts\Http\Kernel $kernel) {
            $this->loadRoutesFrom(__DIR__.'/routes/api.php');
            $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        }

        public function register() {
        }
    }
?>