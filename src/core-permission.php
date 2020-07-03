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
        'register' => base_path('graphql/core/'),
    ],
    'queries' => [
        'register' => base_path('app/GraphQL/Queries/Core')
    ],
    'scalars' => [
        'register' => base_path('app/GraphQL/Scalars/Core')
    ],
    'mutations' => [
        'register' => base_path('app/GraphQL/Mutations/Core')
    ]
];
