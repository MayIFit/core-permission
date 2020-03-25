<?php
    namespace MayIFit\Core\Permission;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Routing\Route;
    use Illuminate\Contracts\Http\Kernel;

    use MayIFit\Core\Permission\Models\Permission;
    use MayIFit\Core\Permission\Policies\PermissionPolicy;

    class PermissionServiceProvider extends ServiceProvider {

        /**
         * The policy mappings for the application.
         *
         * @var array
         */

        public function boot(Route $router, Kernel $kernel) {
            $this->loadRoutesFrom(__DIR__.'/routes/api.php');
            $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        }

        public function register() {
        }
    }
?>