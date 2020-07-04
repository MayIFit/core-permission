<?php

namespace MayIFit\Core\Permission\Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\User;

use MayIFit\Extension\Shop\Tests\TestCase;

class AcquireAuthTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login() {
        parent::setUp();
        
        $mockUser = factory(User::class)->create([
            'password' => bcrypt('test')
        ]);

        $this->graphQL("mutation { loginUser(input:{email: \"".$mockUser->email."\", password:\"test\"}) { email } }")->assertJSON([
            'data' => [
                'loginUser' => [
                    'email' => $mockUser->email
                ]
            ]
        ]);
    }
}
