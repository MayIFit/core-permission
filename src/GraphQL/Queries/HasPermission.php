<?php

namespace MayIFit\Core\Permission\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

/**
 * Class HasPermission
 *
 * @package MayIFit\Core\Permission
 */
class HasPermission
{
    /**
     * Check if the currently authenticated
     * user has a given permission
     * 
     * @return boolean
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        return $context->user->tokenCan($args['entity'].".".$args['permission']);
    }
}