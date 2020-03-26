<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $adminRole = Role::where('name', 'admin')->firstOrFail();
            User::create([
                'email'          => 'admin@admin.com',
                'real_name'      => 'Admin',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'created_by' => 1
            ])->roles()->attach($adminRole);
        }
    }
}
