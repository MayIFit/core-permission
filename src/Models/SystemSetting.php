<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use MayIFit\Core\Permission\Traits\HasUsers;

class SystemSetting extends Model
{
    use SoftDeletes, HasUsers;

    public function save(array $options = array()) {
        $this->created_by = auth()->id() ?? 1;
        $this->updated_by = auth()->id();
        parent::save($options);
    }
    
}
