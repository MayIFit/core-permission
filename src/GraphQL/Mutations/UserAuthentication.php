<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use ReCaptcha\ReCaptcha;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use MayIFit\Core\Permission\Exceptions\MisMatchedAuthorizationRequest;

/**
 * Class UserAuthentication
 *
 * @package MayIFit\Core\Permission
 */
class UserAuthentication
{
    /**
     * Try to authenticate the User
     *
     * @return void
     */
    public static function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $email = $args['email'];
        $password = $args['password'];

        $recaptcha = new ReCaptcha(config('core-permission.google_captcha_secret'));
        $resp = $recaptcha->setExpectedHostname($context->request->getHttpHost())
            ->verify($args['captcha_token'], $context->request->server->get('REMOTE_ADDR'));

        if ($resp->getScore() < 0.7) {
            return response()->json(['captcha' => true]);
        }

        $user = config('auth.providers.users.model')::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new MisMatchedAuthorizationRequest('global.user', 'error.no_matching_credentials_found');
        }

        if (!$user->approved) {
            throw new MisMatchedAuthorizationRequest('global.user', 'error.registration_has_not_been_approved');
        }

        $permissions = Arr::flatten($user->roles->map(function ($role) {
            return $role->permissions->map(function ($permission) {
                return $permission->name . '.' . $permission->method;
            });
        })->toArray());

        $token = $user->createToken(config('app.name'), $permissions)->plainTextToken;
        $user['access_token'] = $token;

        return $user;
    }

    public static function logout($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $context->user->tokens()->delete();
        return false;
    }
}
