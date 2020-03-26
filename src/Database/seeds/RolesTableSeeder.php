<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

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
            Role::firstOrCreate(['name' =>'hr', 'active' => true, 'created_by' => 1]);
            Role::firstOrCreate(['name' => 'user', 'active' => true, 'created_by' => 1]);
        }
    }
}
