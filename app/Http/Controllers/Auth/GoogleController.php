<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HandlesCookies;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleController extends Controller
{
    use HandlesCookies;
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            return redirect(env('APP_URL_FRONT_END'));
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect(env('APP_URL_FRONT_END'));
        }
        $user = User::where('email', $googleUser->getEmail())->first();
        if ($user) {
            // Update existing user
            $user->update([
                'full_name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
        } else {
            // Create new user
            $user = User::create([
                'full_name' => $googleUser->getName(),
                'username' => explode('@', (string)$googleUser->getEmail())[0],
                'email' => $googleUser->getEmail(),
                'password' => $googleUser->getId() . rand(2000, time()),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
        }

        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = JWTAuth::customClaims(['jwt_refresh' => true])->fromUser($user);

        return redirect(env('APP_URL_FRONT_END'))
            ->withCookie($this->buildCookie('jwt_token', $accessToken, 15))
            ->withCookie($this->buildCookie('jwt_refresh', $refreshToken, 60 * 24 * 7));
    }
}
