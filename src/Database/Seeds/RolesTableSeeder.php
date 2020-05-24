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
        $admin_role = Role::firstOrCreate(['name' => 'admin']);
        $admin_role->permissions()->sync(Permission::get());
        Role::firstOrCreate(['name' => 'moderator']);
        Role::firstOrCreate(['name' => 'user']);
    }
}
