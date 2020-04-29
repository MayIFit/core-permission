<?php

namespace App\GraphQL\Mutations\Extensions;

use Illuminate\Support\Facades\Storage;

class Upload
{

    protected $pathMatrix = [
        'product_photo' => 'product_images',
        'product_file' => 'product_additional',
        'user_avatar' => 'images'
    ];

    protected $classMatrix = [
        'product_photo' => \MayIFit\Extension\Shop\Models\Document::class,
        'product_file' => \MayIFit\Extension\Shop\Models\Document::class,
        'user_avatar' => \MayIFit\Core\Permission\Models\Document::class
    ];

    /**
     * Upload a file, store it on the server and return the path.
     *
     * @param  mixed  $root
     * @param  mixed[]  $args
     * @return string|null
     */
    public function resolve($root, array $args): ?string
    {
        $fileInput = $args['input'];
        
        $type = $fileInput['type'];
        
        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $fileInput['file'];
        
        $path = $this->pathMatrix[$type] ?? '';

        if (!$path) {
            return json(['error' => 'Don\'t know where to save file']);
        }

        $storeName = str_replace(' ', '_', $file->getClientOriginalName());

        $storedPath = $file->storeAs($path, $storeName);
        $document = new $this->classMatrix[$type];
        $document->name = $path;
        $document->resource_url = Storage::url($storedPath);
        $document->original_file_name = $file->getClientOriginalName();
        $document->save();


        return $storedPath;
    }
}