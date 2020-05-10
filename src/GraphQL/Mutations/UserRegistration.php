<?php

namespace App\GraphQL\Mutations\Core;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use MayIFit\Core\Permission\Exceptions\MisMatchedAuthorizationRequest;
use App\Models\User;

class UserRegistration
{
    /**
     * Try to register a new User 
     * 
     * @return void
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $email = $args['input']['email'];
        $hashedPassword = $args['input']['password'];
        
        $checkUser = User::where('email', $email)->first();
        if ($checkUser) {
            throw new MisMatchedAuthorizationRequest(
                'error.user_with_email_already_exists',
                ''
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