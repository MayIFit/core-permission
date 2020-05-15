<?php

namespace MayIFit\Core\Permission\Database\Seeds;

use Illuminate\Database\Seeder;
use MayIFit\Core\Translation\Models\Translation;

/**
 * Class TranslationsTableSeeder
 *
 * @package MayIFit\Core\Permission
 */
class TranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addPermissionRelatedTranslations();
        $this->addFileUploadRelatedTranslations();
    }

    protected function addPermissionRelatedTranslations() {
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'has_right'
			],
            ['text' => ['en' => 'Has Right', 'hu' => 'Jogosult']],
		);
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'permissions'
			],
            ['text' => ['en' => 'Permissions', 'hu' => 'Jogosultságok']],
		);
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'permission'
			],
            ['text' => ['en' => 'Permission', 'hu' => 'Jogosultság']],
		);
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'roles'
			],
            ['text' => ['en' => 'Roles', 'hu' => 'Szerepkörök']],
		);
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'role'
			],
            ['text' => ['en' => 'Role', 'hu' => 'Szerepkör']],
		);
    }

    protected function addFileUploadRelatedTranslations() {
        Translation::updateOrCreate([
                'group' => 'files',
                'key' => 'to_upload'
            ],
            ['text' => ['en' => 'To Upload', 'hu' => 'Feltöltendő']],
        );
        Translation::updateOrCreate([
                'group' => 'files',
                'key' => 'drop_zone'
            ],
            ['text' => ['en' => 'Drop Here', 'hu' => 'Ide Dobja']],
        );
        Translation::updateOrCreate([
                'group' => 'files',
                'key' => 'no_selected'
            ],
            ['text' => ['en' => 'No File Selected', 'hu' => 'Nincs kiválasztott fájl']],
        );
        Translation::updateOrCreate([
                'group' => 'files',
                'key' => 'upload_file'
            ],
            ['text' => ['en' => 'Upload File', 'hu' => 'Fájl Feltöltése']],
        );
    }
}
