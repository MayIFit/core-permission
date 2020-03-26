<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;

use MayIFit\Core\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::count() == 0) {
            Role::firstOrCreate(['name' => 'admin', 'active' => true, 'created_by' => 1]);
            Role::firstOrCreate(['name' => 'moderator', 'active' => true, 'created_by' => 1]);
            Role::firstOrCreate(['name' => 'user', 'active' => true, 'created_by' => 1]);
        }
    }
}
