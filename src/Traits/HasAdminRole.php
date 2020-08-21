<?php

namespace MayIFit\Core\Permission\Traits;

/**
 * Trait HasAdminRole
 *
 * @package MayIFit\Core\Permission
 */
trait HasAdminRole {

    /**
     * @return bool
     */
    public function isAdministrator() {
        return $this->hasRole('admin');
    }
}