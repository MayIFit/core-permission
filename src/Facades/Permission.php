<?php

namespace MayIFit\Core\Permission\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Permission
 *
 * @package MayIFit\Core\Permission
 */
class Permission extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'permission';
    }
}