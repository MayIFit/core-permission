<?php

namespace MayIFit\Core\Permission\Traits;

/**
 * Class HasAdminRole
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait HasAdminRole {

    /**
     * @return bool
     */
    public function isAdministrator() {
        return $this->hasRole('admin');
    }
}