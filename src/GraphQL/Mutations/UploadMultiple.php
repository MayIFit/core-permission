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
        
        $retPaths = [];
        
        foreach ($files as $element) {
            $type = $element['type'];
            
            /** @var \Illuminate\Http\UploadedFile $file */
            $file = $element['file'];
            
            $path = $this->pathMatrix[$type] ?? '';
    
            if (!$path) {
                return json(['error' => 'Don\'t know where to save file']);
            }

            $storeName = str_replace(' ', '_', $file->getClientOriginalName());

            $storedPath = $file->storeAs($path, $storeName);
            $document = new Document();
            $document->name = $path;
            $document->resource_url = Storage::url($storedPath);
            $document->original_file_name = $file->getClientOriginalName();
            $document->save();
    
            $retPaths[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $document->resource_url
            ];
        }
        return $retPaths;
    }
}