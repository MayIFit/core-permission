<?php

namespace MayIFit\Permissions\Traits;

/**
 * Class HasAdminRole
 *
 * @package MayIFit\Permissions\Traits
 */
trait HasAdminRole {

    /**
     * @return bool
     */
    public function isAdministrator() {
        return $this->hasRole('admin');
    }
}