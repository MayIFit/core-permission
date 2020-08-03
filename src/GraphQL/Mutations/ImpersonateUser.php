<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class ImpersonateUser
{
    /**
     * Try to impersonate a User
     * 
     * @return void
     */
    public static function impersonate($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $id = $args['id'];

        if (!$context->user->tokenCan('impersonate.user')) {
            return $context->user;
        }

        $user = config('auth.providers.users.model')::find($id)->first();
        Auth::setUser($user);

        $permissions = Arr::flatten($user->roles->map(function ($role) { 
            return $role->permissions->map(function ($permission){
                return $permission->name.'.'.$permission->method;
            });
        })->toArray());

        $token = $user->createToken(config('app.name'), $permissions)->plainTextToken;
        $user['access_token'] = $token;

        return $user;
    }
}