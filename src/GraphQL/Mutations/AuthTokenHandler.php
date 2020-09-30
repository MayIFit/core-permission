<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

/**
 * Class AuthTokenHandler
 *
 */
class AuthTokenHandler
{
    /**
     * Try to authenticate the User
     *
     * @return void
     */
    public static function create($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $tokenName = $args['name'];

        $permissions = $context->user->permissions()->get(['name', 'method'])->map(function ($perm) {
            return $perm->name . '.' . $perm->method;
        });

        dd($permissions);

        return $context->user->createToken($tokenName, $permissions)->plainTextToken;
    }

    public static function revoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $context->user->tokens()->where('id', $args['id'])->delete();
        return true;
    }
}
