<?php

namespace MayIFit\Core\Permission\GraphQL\Mutations;

use ReCaptcha\ReCaptcha;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Notifications\Registration;
use MayIFit\Core\Permission\Notifications\NewRegistration;

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
    public static function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $email = $args['email'];
        $hashedPassword = $args['password'];

        $recaptcha = new ReCaptcha(config('core-permission.google_captcha_secret'));
        $resp = $recaptcha->setExpectedHostname($context->request->getHttpHost())
            ->verify($args['captcha_token'], $context->request->server->get('REMOTE_ADDR'));

        if ($resp->getScore() < 0.7) {
            return response()->json(['captcha' => true]);
        }

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
        Notification::route('mail', 'info@gude.hu')
            ->notify(new NewRegistration($user->email));

        return $user;
    }
}
