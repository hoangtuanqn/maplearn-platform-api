<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\HandlesCookies;


class OAuthController extends Controller
{
    use HandlesCookies;

    private array $allowedProviders = ['google', 'facebook'];

    public function redirect($provider)
    {
        $this->ensureProviderAllowed($provider);
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback($provider)
    {
        $this->ensureProviderAllowed($provider);

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect(env('APP_URL_FRONT_END'));
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Update existing user
            $user->update([
                'full_name' => $socialUser->getName(),
                "{$provider}_id" => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } else {
            // Create new user
            $user = User::create([
                'full_name' => $socialUser->getName(),
                'username' => $socialUser->getNickname() ?: 'user_' . time(),
                'email' => $socialUser->getEmail(),
                'password' => $socialUser->getId() . rand(2000, time()),
                "{$provider}_id" => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        }
        $accessToken = JWTAuth::fromUser($user);
        if ($user->google2fa_secret) {
            return redirect(env('APP_URL_FRONT_END') . "/authentication-social")
                ->withCookie(cookie(
                    'token_2fa',
                    base64_encode(JWTAuth::fromUser($user) . env('T1_SECRET', "")),
                    15,
                    null,
                    null,
                    false,
                    false
                ));
        } else {
            $refreshToken = JWTAuth::customClaims(['jwt_refresh' => true])->fromUser($user);
            return redirect(env('APP_URL_FRONT_END') . "/authentication-social")
                ->withCookie($this->buildCookie('jwt_token', $accessToken, 15))
                ->withCookie($this->buildCookie('jwt_refresh', $refreshToken, 60 * 24 * 7));
        }
    }

    private function ensureProviderAllowed($provider)
    {
        if (!in_array($provider, $this->allowedProviders)) {
            abort(404);
        }
    }
}
