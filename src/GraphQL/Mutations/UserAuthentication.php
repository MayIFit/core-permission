<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

use MayIFit\Core\Permission\Exceptions\MisMatchedAuthorizationRequest;

class UserAuthentication
{
    /**
     * Try to authenticate the User
     * 
     * @return void
     */
    public static function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $email = $args['email'];
        $password = $args['password'];
        $user = config('auth.providers.users.model')::where('email', $email)->first();
        
        if (!$user || !Hash::check($password, $user->password)) {
            throw new MisMatchedAuthorizationRequest(
                'error.no_matching_credentials_found',
                ''
            );
        }
        $result = $user->has('roles.permissions')->orHas('permissions')->find($user->id);
        $permissions = Arr::flatten($result->roles->map(function ($role) { 
            return $role->permissions->map(function ($permission){
                return $permission->name.'.'.$permission->method;
            });
        })->toArray());
        $token = $user->createToken(config('app.name'), $permissions)->plainTextToken;
        $user['access_token'] = $token;

        return $user;
    }

    public static function logout($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $context->user->tokens()->delete();
        return false;
    }
}