<?php
    namespace MayIFit\Core\Permission;

    use Illuminate\Support\ServiceProvider;
    
    use MayIFit\Core\Permission\Models\Permission; 
    use MayIFit\Core\Permission\Policies\PermissionPolicy; 
    use MayIFit\Core\Permission\Http\Middleware\PermissionMiddleware; 

    class PermissionServiceProvider extends ServiceProvider {

        /**
         * The policy mappings for the application.
         *
         * @var array
         */
        protected $policies = [
            Permission::class => PermissionPolicy::class,
        ];

        public function boot() {
            $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
            app('router')->aliasMiddleware('mayifit/core-permission', PermissionMiddleware::class);
        }

        public function register() {
            $this->app->bind('permission', function () {
                return new Permission();
            });
        }
    }
?>