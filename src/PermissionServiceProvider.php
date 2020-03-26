<?php
    namespace MayIFit\Core\Permission;

    use Illuminate\Support\ServiceProvider;

    class PermissionServiceProvider extends ServiceProvider {

        /**
         * The policy mappings for the application.
         *
         * @var array
         */

        public function boot() {
            $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        }

        public function register() {
            $this->app->bind('permission', function () {
                return new Permission();
            });
        }
    }
?>