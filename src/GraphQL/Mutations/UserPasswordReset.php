<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;


use MayIFit\Core\Permission\Exceptions\MisMatchedAuthorizationRequest;
use MayIFit\Core\Permission\Notifications\PasswordReset;

/**
 * Class UserPasswordReset
 *
 * @package MayIFit\Core\Permission
 */
class UserPasswordReset
{
    /**
     * Try to change the password of the registered User 
     * 
     * @return App\Models\User
     */
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): User {
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
        
        $checkUser = config('auth.providers.users.model')::where('email', $email)->first();
        if (!$checkUser) {
            throw new MisMatchedAuthorizationRequest(
                'error.user_with_email_not_found',
                ''
            );
        }

        $checkUser->password = $hashedPassword;
        $checkUser->save();
        DB::table('password_resets')->where('email', $checkUser->email)
            ->delete();
    
        $token = $checkUser->createToken(config('app.name'))->plainTextToken;
        $checkUser['access_token'] = $token;
    
        return $checkUser;
    }

    /**
     * Send a password reset notification for the registered User
     * 
     * @return void
     */
    public static function sendEmailNotification($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): void {
        $email = $args['email'];
        
        $checkUser = config('auth.providers.users.model')::where('email', $email)->first();
        if (!$checkUser) {
            throw new MisMatchedAuthorizationRequest(
                'error.user_with_email_not_found',
                ''
            );
        }

        DB::table('password_resets')->insert([
            'email' => $checkUser->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $checkUser->email)->first();

        $link = '/password-reset/' . $tokenData->token . '?email=' . urlencode($checkUser->email);

        $checkUser->notify(new PasswordReset($link));
    }
}