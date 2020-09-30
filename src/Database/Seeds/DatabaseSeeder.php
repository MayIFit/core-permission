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
            RolesTableSeeder::class,
            TranslationsTableSeeder::class,
        ]);
    }
}
