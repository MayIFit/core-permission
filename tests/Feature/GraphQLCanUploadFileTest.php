<?php

namespace MayIFit\Core\Permission\Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

use MayIFit\Core\Permission\Tests\TestCase;
use MayIFit\Core\Permission\Tests\User;

class GraphQLCanUploadFileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_files()
    {
        parent::setUp();

        $user = factory(User::class)->create();
        Sanctum::actingAs($user, ['*']);

        $mockFile = UploadedFile::fake()->create('image.jpg', 500);
        $response = $this->multipartGraphQL(
            [
                'operations' =>
                /** @lang JSON */
                '
                    {
                        "query": "mutation Upload($input: FileUploadInput!) { upload(input: $input) }",
                        "variables": {
                            "input": {
                                "file": null,
                                "type": "product_photo"
                            }
                        }
                    }
                ',
                'map' =>
                /** @lang JSON */
                '
                    {
                        "0": ["variables.input.file"]
                    }
                ',
            ],
            [
                '0' =>  $mockFile,
            ]
        )->assertStatus(200);
        Storage::assertExists('public/product_images/' . $response['data']['upload']['name']);
    }
}
