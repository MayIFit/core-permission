<?php
    namespace MayIFit\Core\Permission;

    use Illuminate\Console\Events\CommandFinished;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Event;
    use Illuminate\Support\Facades\Request;
    use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

    use Illuminate\Support\Facades\Gate;
    use Symfony\Component\Console\Output\ConsoleOutput;
    
    use MayIFit\Core\Permission\Models\Permission;
    use MayIFit\Core\Permission\Models\Role;
    use MayIFit\Core\Permission\Models\User; 
    use MayIFit\Core\Permission\Policies\PermissionPolicy; 
    use MayIFit\Core\Permission\Policies\RolePolicy; 
    use MayIFit\Core\Permission\Policies\UserPolicy; 

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
        ];

        /**
         * The seed folder for the package.
         *
         * @var array
         */
        protected $database_folder = '/database';

        public function boot() {
            $this->loadMigrationsFrom(__DIR__.$this->database_folder.'/migrations');
            if ($this->app->runningInConsole()) {
                if ($this->isConsoleCommandContains([ 'db:seed', '--seed' ], [ '--class', 'help', '-h' ])) {
                    $this->addSeedsAfterConsoleCommandFinished();
                }
            }
            $this->publishes([
                __DIR__.'/GraphQL/schema' => './graphql',
            ], '/');
            $this->publishes([
                __DIR__.'/GraphQL/Mutations' => './App/GraphQL/Mutations',
            ], '/');
            $this->registerPolicies();
        }

        public function register() {
            $this->app->bind('permission', function () {
                return new Permission();
            });
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
                if (str_contains($command, $contain_options) && ($exclude_options == null || !str_contains($command, $exclude_options))) {
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
                    $this->addSeedsFrom(__DIR__ . $this->database_folder.'/seeds');
                }
            });
        }

        /**
         * Register seeds.
         *
         * @param string  $seeds_path
         * @return void
         */
        protected function addSeedsFrom($seeds_path) {
            $file_names = glob( $seeds_path . '/*.php');
            foreach ($file_names as $filename)
            {
                $classes = $this->getClassesFromFile($filename);
                foreach ($classes as $class) {
                    Artisan::call('db:seed', [ '--class' => $class, '--force' => '' ]);
                }
            }
        }

        /**
         * Get full class names declared in the specified file.
         *
         * @param string $filename
         * @return array an array of class names.
         */
        private function getClassesFromFile(string $filename) : array {
            // Get namespace of class (if vary)
            $namespace = "";
            $lines = file($filename);
            $namespaceLines = preg_grep('/^namespace /', $lines);
            if (is_array($namespaceLines)) {
                $namespaceLine = array_shift($namespaceLines);
                $match = array();
                preg_match('/^namespace (.*);$/', $namespaceLine, $match);
                $namespace = array_pop($match);
            }

            // Get name of all class has in the file.
            $classes = array();
            $php_code = file_get_contents($filename);
            $tokens = token_get_all($php_code);
            $count = count($tokens);
            for ($i = 2; $i < $count; $i++) {
                if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                    $class_name = $tokens[$i][1];
                    if ($namespace !== "") {
                        $classes[] = $namespace . "\\$class_name";
                    } else {
                        $classes[] = $class_name;
                    }
                }
            }

            return $classes;
        }
    }
?>