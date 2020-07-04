<?php

namespace MayIFit\Core\Permission\Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\User;

use MayIFit\Extension\Shop\Tests\TestCase;

class GraphQLGetAuthUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_user_can_be_retrieved(): void {
        parent::setUp();
        
        $mockUser = factory(User::class)->create();
        Sanctum::actingAs(
           $mockUser
        );
    
        $this->graphQL("{ me { name } }")->assertJSON([
            'data' => [
                'me' => [
                    'name' => $mockUser->name
                ]
            ]

        ]);
    }
}
