<?php

namespace MayIFit\Core\Permission\Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use MayIFit\Core\Permission\Tests\TestCase;

class GraphQLUnAuthUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauth_user_cant_be_retrieved(): void {
        parent::setUp();
    
        $this->graphQL("{ me { name } }")->assertJSON([
            'data' => [
                'me' => null
            ]
        ]);
    }
}
