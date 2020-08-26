<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Schema Location
    |--------------------------------------------------------------------------
    |
    | Path to your .graphql schema file.
    | Additional schema files may be imported from within that file.
    |
    */

    'schema' => [
        'register' => base_path('graphql/core'),
    ],
    'queries' => [
        'register' => base_path('app/GraphQL/Queries')
    ],
    'scalars' => [
        'register' => base_path('app/GraphQL/Scalars')
    ],
    'mutations' => [
        'register' => base_path('app/GraphQL/Mutations')
    ],
    'google_captcha_secret' => env('GOOGLE_CAPTCHA_SECRET', ''),
];
