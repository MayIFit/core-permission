<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use Illuminate\Support\Str;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Notifications\Registration;

use App\Models\User;

/**
 * Class UserRegistration
 *
 * @package MayIFit\Core\Permission
 */
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
        if ($user->approved) {
            $token = $user->createToken(config('app.name'))->plainTextToken;
            $user['access_token'] = $token;
        }

        $user->notify(new Registration);
        
        return $user;
    }
}