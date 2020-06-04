<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use MayIFit\Core\Permission\Traits\Lockable;
use MayIFit\Core\Permission\Traits\HasRoles;
use MayIFit\Core\Permission\Traits\HasAdminRole;
use MayIFit\Core\Permission\Traits\HasPermissions;
use MayIFit\Core\Permission\Traits\HasDocuments;


class User extends Authenticatable {
    use HasRoles, HasAdminRole, HasPermissions, Lockable, HasApiTokens, HasDocuments;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'provider', 'provider_id'
    ];

    public function save(array $options = array()) {
        $this->created_by = auth()->id();
        $this->updated_by = auth()->id();
        parent::save($options);
    }
    
}
