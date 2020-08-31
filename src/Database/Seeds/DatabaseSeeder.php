<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * @package MayIFit\Core\Permission
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            TranslationsTableSeeder::class,
        ]);
    }
}
