<?php

namespace App\GraphQL\Mutations\Extensions;

use Illuminate\Support\Facades\Storage;

use \MayIFit\Core\Permission\Models\Document;

class Upload
{

    protected $pathMatrix = [
        'product_photo' => 'product_images',
        'product_file' => 'public/product_additional',
        'user_avatar' => 'public/images'
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
        $type = $args['type'];
        
        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $args['file'];
        
        $path = $this->pathMatrix[$type] ?? '';

        if (!$path) {
            return json(['error' => 'Don\'t know where to save file']);
        }

        $storedPath = $file->store($path);
        $pathArray = explode('/', $storedPath);
        $name = array_pop($pathArray);

        $document = new Document();
        $document->name = $name;
        $document->type = $file->getMimeType();
        $document->size = $file->getSize();
        $document->resource_url = Storage::url($storedPath);
        $document->original_filename = $file->getClientOriginalName();
        $document->save();

        return [
            'original_filename' => $file->getClientOriginalName(),
            'name' => $document->name,
            'resource_url' => $document->resource_url,
            'size' => $document->size,
            'type' => $document->type,
            'id' => $document->id
        ];
    }
}