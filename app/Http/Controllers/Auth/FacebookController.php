<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\HandlesCookies;


class FacebookController extends Controller
{
    use HandlesCookies;

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect(env('APP_URL_FRONT_END'));
        }

        $user = User::where('email', $facebookUser->getEmail())->first();

        if ($user) {
            // Update existing user
            $user->update([
                'full_name' => $facebookUser->getName(),
                'facebook_id' => $facebookUser->getId(),
                'avatar' => $facebookUser->getAvatar(),
            ]);
        } else {
            // Create new user
            $user = User::create([
                'full_name' => $facebookUser->getName(),
                'username' => explode('@', (string)$facebookUser->getEmail())[0],
                'email' => $facebookUser->getEmail(),
                'password' => $facebookUser->getId() . rand(2000, time()),
                'facebook_id' => $facebookUser->getId(),
                'avatar' => $facebookUser->getAvatar(),
            ]);
        }

        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = JWTAuth::customClaims(['jwt_refresh' => true])->fromUser($user);

        return redirect(env('APP_URL_FRONT_END'))
            ->withCookie($this->buildCookie('jwt_token', $accessToken, 15))
            ->withCookie($this->buildCookie('jwt_refresh', $refreshToken, 60 * 24 * 7));
    }
}
