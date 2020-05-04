<?php

namespace App\GraphQL\Mutations\Extensions;

use Illuminate\Support\Facades\Storage;

use \MayIFit\Core\Permission\Models\Document;

class UploadMultiple
{

    protected $pathMatrix = [
        'product_photo' => 'product_images',
        'product_file' => 'product_additional',
        'user_avatar' => 'images'
    ];

    /**
     * Upload a file, store it on the server and return the path.
     *
     * @param  mixed  $root
     * @param  mixed[]  $args
     * @return string|null
     */
    public function resolve($root, array $args): ?array
    {
        $files = $args['input'];
        
        $retFiles = [];
        
        foreach ($files as $element) {
            $type = $element['type'];
            
            /** @var \Illuminate\Http\UploadedFile $file */
            $file = $element['file'];
            
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
            $document->original_file_name = $file->getClientOriginalName();
            $document->save();
    
            $retFiles[] = [
                'original_name' => $file->getClientOriginalName(),
                'name' => $document->name,
                'resource_url' => $document->resource_url,
                'size' => $document->size,
                'type' => $document->type,
                'id' => $document->id
            ];
        }
        return $retFiles;
    }
}