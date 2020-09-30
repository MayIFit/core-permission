<?php

namespace MayIFit\Core\Permission\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use MayIFit\Core\Permission\Tests\TestCase;
use MayIFit\Core\Permission\Tests\User;
use MayIFit\Core\Permission\Models\Permission;

class PermissionIsGrantableTest extends TestCase
{
    use RefreshDatabase;

    public function test_permission_is_assignable()
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $randomPermission = Permission::inRandomOrder()->first();

        $user->grantPermission($randomPermission);

        $this->assertEquals(true, $user->hasPermission($randomPermission));
    }
}
