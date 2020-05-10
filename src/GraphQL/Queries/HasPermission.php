<?php

namespace App\GraphQL\Queries\Extensions;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class HasPermission
{
    /**
     * Check if the currently authenticated
     * user has a given permission
     * 
     * @return void
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        return Auth::user()->hasPermission($args['entity'].$args['permission']);
    }
}