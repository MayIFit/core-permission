<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

/**
 * Class ImpersonateUser
 *
 * @package MayIFit\Core\Permission
 */
class ImpersonateUser
{
    /**
     * Try to impersonate a User
     *
     * @return void
     */
    public static function impersonate($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $id = $args['id'];

        if (!$context->user->tokenCan('user.impersonate')) {
            return $context->user;
        }

        $user = config('auth.providers.users.model')::find($id);
        Auth::setUser($user);

        $permissions = Arr::flatten($user->roles->map(function ($role) {
            return $role->permissions->map(function ($permission) {
                return $permission->name . '.' . $permission->method;
            });
        })->toArray());

        $token = $user->createToken(config('app.name'), $permissions)->plainTextToken;
        $user['access_token'] = $token;

        return $user;
    }
}
