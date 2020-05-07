<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;
use MayIFit\Core\Translation\Models\Translation;

/**
 * Class TranslationsTableSeeder
 *
 * @package MayIFit\Core\Permission
 */
class TranslationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addPermissionRelatedTranslations();
    }

    protected function addPermissionRelatedTranslations() {
        Translation::updateOrCreate([
            'group' => 'permission',
            'key' => 'has_right',
            'text' => ['en' => 'Has Right', 'hu' => 'Jogosult'],
        ]);
        Translation::updateOrCreate([
            'group' => 'permission',
            'key' => 'permissions',
            'text' => ['en' => 'Permissions', 'hu' => 'Jogosultságok'],
        ]);
        Translation::updateOrCreate([
            'group' => 'permission',
            'key' => 'permission',
            'text' => ['en' => 'Permission', 'hu' => 'Jogosultság'],
        ]);
        Translation::updateOrCreate([
            'group' => 'permission',
            'key' => 'roles',
            'text' => ['en' => 'Roles', 'hu' => 'Szerepkörök'],
        ]);
        Translation::updateOrCreate([
            'group' => 'permission',
            'key' => 'role',
            'text' => ['en' => 'Role', 'hu' => 'Szerepkör'],
        ]);
    }
}
