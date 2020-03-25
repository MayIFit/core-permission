<?php

namespace MayIFit\Core\Permissions\Traits;

/**
 * Class HasAdminRole
 *
 * @package MayIFit\Core\Permissions\Traits
 */
trait HasAdminRole {

    /**
     * @return bool
     */
    public function isAdministrator() {
        return $this->hasRole('admin');
    }
}