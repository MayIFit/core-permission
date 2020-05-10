<?php

namespace App\GraphQL\Mutations\Core;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use MayIFit\Core\Permission\Exceptions\MisMatchedAuthorizationRequest;
use App\Models\User;

class UserUnathentication
{
    /**
     * Try to register a new User 
     * 
     * @return void
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        Auth::user()->tokens()->delete();
        return false;
    }
}