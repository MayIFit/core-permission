<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;

use MayIFit\Core\Permission\Exceptions\MisMatchedAuthorizationRequest;
use MayIFit\Core\Permission\Models\Role;

class UserRegistration
{
    /**
     * Try to register a new User 
     * 
     * @return void
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $email = $args['email'];
        $hashedPassword = $args['password'];
        
        $user = User::create([
            'email'          => $email,
            'name'           => Str::random(60),
            'password'       => $hashedPassword,
            'remember_token' => Str::random(60)
        ]);

        $user->roles()->attach(Role::where('default_role', true)->first());
    
        $token = $user->createToken(config('app.name'))->plainTextToken;
        $user['access_token'] = $token;
        
        return $user;
    }
}