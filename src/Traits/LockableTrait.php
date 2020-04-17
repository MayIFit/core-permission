<?php

namespace MayIFit\Core\Permission\Traits;

use Session;

/**
 * Class Lockable
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait LockableTrait {

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