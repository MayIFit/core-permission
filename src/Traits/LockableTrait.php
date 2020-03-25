<?php

namespace MayIFit\Core\Permissions\Traits;

use Session;

/**
 * Class Lockable
 *
 * @package MayIFit\Core\Permissions\Traits
 */
trait Lockable {

    /**
     * @return double
     */
    public function getLockoutTime() {
        return $this->lockout_time;
    }

    /**
     * @return bool
     */
    public function isLocked() {
        if ($this->hasLockoutTime()) {
            return session('lock-expires-at') <= now();
        }
        return false;
    }

    /**
     * @return bool
     */
    public function hasLockoutTime() {
        return $this->getLockoutTime() > 0;
    }
}