<?php

namespace MayIFit\Core\Permission\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use MayIFit\Core\Permission\Tests\TestCase;
use MayIFit\Core\Permission\Tests\User;
use MayIFit\Core\Permission\Models\Role;

class RoleIsGrantableTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_is_assignable()
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $moderatorRole = Role::where('name', '=', 'moderator')->first();

        $user->grantRole($moderatorRole);

        $this->assertEquals(true, $user->hasRole('moderator'));
    }
}
