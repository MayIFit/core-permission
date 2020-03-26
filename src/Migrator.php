<?php
 
namespace MayIFit\Core\Permission;
 
use Illuminate\Database\Migrations\Migrator as Base;
 
class Migrator extends Base
{
    /**
     * Resolve a migration instance from a file.
     *
     * @param string $file
     * @return object
     */
    public function resolve($file) {
        $file = implode("_", array_slice(explode("_", $file), 4));
        $class = "MayIFit\\Core\\Permission\\Database\\Migrations" . studly_case($file);
    
        return new $class;
    }
}