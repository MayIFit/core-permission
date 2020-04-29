<?php

namespace App\GraphQL\Mutations\Extensions;

class Upload
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
    public function resolve($root, array $args): ?string
    {
        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $args['file'];
        $type = $args['type'];

        $args->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg,doc,xls,pdf,csv,xlsx|max:10240',
        ]);
        
        $path = $pathMatrix[$type] ?? '';

        if (!$path) {
            return response()->json(['error' => 'Don\'t know where to save file']);
        }

        return $file->storeAs($path, $file.'.'.$file->getClientOriginalExtension());
    }
}