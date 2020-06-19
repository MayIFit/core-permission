<?php

namespace App\GraphQL\Mutations\Core;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use MayIFit\Core\Permission\Exceptions\MisMatchedAuthorizationRequest;
use App\Models\User;

class UserPasswordReset
{
    /**
     * Try to register a new User 
     * 
     * @return void
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $email = $args['email'];
        $resetToken = $args['token'];
        $hashedPassword = $args['password'];

        $tokenData = DB::table('password_resets')
            ->where('token', $resetToken)->first();
        
        if (!$tokenData) {
            throw new MisMatchedAuthorizationRequest(
                'error.not_valid_token',
                ''
            );
        }
        
        $checkUser = User::where('email', $email)->first();
        if (!$checkUser) {
            throw new MisMatchedAuthorizationRequest(
                'error.user_with_email_not_found',
                ''
            );
        }

        $checkUser->password = $hashedPassword;
        $checkUser->save();
        DB::table('password_resets')->where('email', $user->email)
            ->delete();
    
        $token = $user->createToken(config('app.name'))->plainTextToken;
        $user['access_token'] = $token;
    
        return $user;
    }
}