<?php

namespace App\GraphQL\Queries\Core;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use MayIFit\Core\Permission\Exceptions\MisMatchedAuthorizationRequest;
use App\Models\User;

class UserAuthentication
{
    /**
     * Try to authenticate the User
     * 
     * @return void
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $email = $args['input']['email'];
        $password = $args['input']['password'];

        $user = User::where('email', $email)->first();
    
        if (!$user || !Hash::check($password, $user->password)) {
            throw new MisMatchedAuthorizationRequest(
                'error.no_matching_credentials_found',
                ''
            );
        }
    
        $token = $user->createToken(config('app.name'))->plainTextToken;
    
        $response = [
            'user' => $user,
            'access_token' => $token
        ];

        return $response;
    }
}