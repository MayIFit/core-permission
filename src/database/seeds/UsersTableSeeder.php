<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use MayIFit\Core\Permission\Models\User;
use MayIFit\Core\Permission\Models\Role;

/**
 * Class UsersTableSeeder
 *
 * @package MayIFit\Core\Permission
 */
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
            $systemUser = User::create([
                'email'          => '',
                'real_name'      => 'system',
                'name'           => 'system',
                'password'       => bcrypt('a^MvR$jr>h9DyM<4x"AUV"#dg{4jCdawtJ29V}2$'),
                'remember_token' => Str::random(60),
                'created_by'     => 1
            ]);
            $adminRole = Role::where('name', 'admin')->firstOrFail();
            User::create([
                'email'          => 'admin@admin.com',
                'real_name'      => 'Admin',
                'name'           => 'admin',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
                'created_by'     => 1
            ])->roles()->attach($adminRole);

            if (env("APP_ENV") !== 'production') {
                print $systemUser->createToken('development')->plainTextToken;
            }
        }
    }
}
