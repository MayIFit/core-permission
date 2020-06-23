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
        $this->globalTranslations();
    }

    protected function globalTranslations() {
        Translation::updateOrCreate([
                'group' => 'list',
                'key' => 'permission'
            ],
            ['text' => ['en' => 'permission list', 'hu' => 'jogosultság lista']],
        );
        Translation::updateOrCreate([
                'group' => 'list',
                'key' => 'user'
            ],
            ['text' => ['en' => 'user list', 'hu' => 'felhasználó lista']],
        );
        Translation::updateOrCreate([
                'group' => 'list',
                'key' => 'role'
            ],
            ['text' => ['en' => 'role list', 'hu' => 'szerepkör lista']],
        );
    }

    protected function addPermissionRelatedTranslations() {
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'has_right'
			],
            ['text' => ['en' => 'has right', 'hu' => 'jogosult']],
		);
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'permissions'
			],
            ['text' => ['en' => 'permissions', 'hu' => 'jogosultságok']],
		);
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'permission'
			],
            ['text' => ['en' => 'permission', 'hu' => 'jogosultság']],
		);
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'roles'
			],
            ['text' => ['en' => 'roles', 'hu' => 'szerepkörök']],
		);
        Translation::updateOrCreate([
	            'group' => 'permission',
	            'key' => 'role'
			],
            ['text' => ['en' => 'role', 'hu' => 'szerepkör']],
		);
    }

    protected function addFileUploadRelatedTranslations() {
        Translation::updateOrCreate([
                'group' => 'files',
                'key' => 'to_upload'
            ],
            ['text' => ['en' => 'to upload', 'hu' => 'feltöltendő']],
        );
        Translation::updateOrCreate([
                'group' => 'files',
                'key' => 'drop_zone'
            ],
            ['text' => ['en' => 'drop here', 'hu' => 'ide dobja']],
        );
        Translation::updateOrCreate([
                'group' => 'files',
                'key' => 'no_selected'
            ],
            ['text' => ['en' => 'no file selected', 'hu' => 'nincs kiválasztott fájl']],
        );
        Translation::updateOrCreate([
                'group' => 'files',
                'key' => 'upload_file'
            ],
            ['text' => ['en' => 'upload file', 'hu' => 'fájl feltöltése']],
        );
    }
}
