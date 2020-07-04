<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;

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

        $user = User::where('email', $email)->first();
    
        if (!$user || !Hash::check($password, $user->password)) {
            throw new MisMatchedAuthorizationRequest(
                'error.no_matching_credentials_found',
                ''
            );
        }
    
        $token = $user->createToken(config('app.name'))->plainTextToken;
        $user['access_token'] = $token;

        return $user;
    }

    public static function logout($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $context->user->tokens()->delete();
        return false;
    }
}