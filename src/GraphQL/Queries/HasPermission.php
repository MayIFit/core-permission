<?php

namespace App\GraphQL\Queries\Core;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class HasPermission
{
    /**
     * Check if the currently authenticated
     * user has a given permission
     * 
     * @return void
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        return $context->user->hasPermission($args['entity'], $args['permission']);
    }
}