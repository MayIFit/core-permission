<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use Illuminate\Support\Facades\Storage;

use MayIFit\Core\Permission\Models\Document;

/**
 * Class UploadMultiple
 *
 * @package MayIFit\Core\Permission
 */
class UploadMultiple
{
    protected $pathMatrix = [
        'product_photo' => 'public/product_images',
        'product_file' => 'public/product_additional'
    ];

    /**
     * Upload a file, store it on the server and return the path.
     *
     * @param  mixed  $root
     * @param  mixed[]  $args
     * @return array|null
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
                $storedPath = $file->storeAs('private/uploads', str_replace(' ', '_', $file->getClientOriginalName()));
            } else {
                $storedPath = $file->store($path);
            }

            $pathArray = explode('/', $storedPath);
            $name = array_pop($pathArray);

            $document = new Document();
            $document->name = $name;
            $document->resource_path = $storedPath;
            $document->type = $file->getMimeType();
            $document->size = $file->getSize();
            $document->resource_url = rtrim(config('app.url'), '/') . Storage::url($storedPath);
            $document->original_filename = $file->getClientOriginalName();
            $document->save();

            $retFiles[] = [
                'original_filename' => $file->getClientOriginalName(),
                'name' => $document->name,
                'resource_url' => $document->resource_url,
                'resource_path' => $document->resource_path,
                'size' => $document->size,
                'type' => $document->type,
                'id' => $document->id
            ];
        }
        return $retFiles;
    }
}
