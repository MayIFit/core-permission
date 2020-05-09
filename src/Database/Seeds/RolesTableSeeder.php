<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Models\Permission;

/**
 * Class RolesTableSeeder
 *
 * @package MayIFit\Core\Permission
 */
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $admin_role = Role::firstOrCreate(['name' => 'admin', 'active' => true, 'created_by' => 1]);
        $admin_role->permissions()->attach(Permission::get());
        Role::firstOrCreate(['name' => 'moderator', 'active' => true, 'created_by' => 1]);
        Role::firstOrCreate(['name' => 'user', 'active' => true, 'created_by' => 1]);
    }
}
