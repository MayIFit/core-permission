<?php

namespace App\GraphQL\Queries\Extensions;

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
    public static function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $email = $args['email'];
        $password = $args['password'];

        $user = User::where('email', $email)->first();
    
        if (!$user || !Hash::check($password, $user->password)) {
            throw new MisMatchedAuthorizationRequest(
                'error.no_matching_credentials_found',
            );
        }
    
        $token = $user->createToken(config('app.name'))->plainTextToken;
    
        $response = [
            'user' => $user,
            'access_token' => $token
        ];

        return $response;
    }

    /**
     * Try to register a new User 
     * 
     * @return void
     */
    public static function register($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $email = $args['email'];
        $hashedPassword = $args['password'];
        
        $checkUser = User::where('email', $email)->first();
        if ($checkUser) {
            throw new MisMatchedAuthorizationRequest(
                'error.user_with_email_already_exists'
            );
        }

        $user = User::create([
            'email'          => $email,
            'name'           => Str::random(60),
            'password'       => $hashedPassword,
            'remember_token' => Str::random(60)
        ]);
    
        $token = $user->createToken(config('app.name'))->plainTextToken;
    
        $response = [
            'user' => $user,
            'access_token' => $token
        ];

        return $response;
    }
}