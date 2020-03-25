<?php
    namespace MayIFit\Core\Permissions;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Routing\Route;
    use Illuminate\Contracts\Http\Kernel;

    use MayIFit\Core\Permissions\Models\Permission;
    use MayIFit\Core\Permissions\Policies\PermissionPolicy;

    class PermissionsServiceProvider extends ServiceProvider {

        /**
         * The policy mappings for the application.
         *
         * @var array
         */
        protected $policies = [
            Permission::class => PermissionPolicy::class,
        ];

        public function boot(Route $router, Kernel $kernel) {
            $this->loadRoutesFrom(__DIR__.'/routes/api.php');
            $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
            $this->registerPolicies();
        }

        public function register() {
        }
    }
?>