<?php

namespace App\Traits;

use App\Models\User;
use Symfony\Component\HttpFoundation\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;

trait HandlesCookies
{
    private function respondWithToken(User $user, string $message, int $status = 200)
    {
        $timeLiveToken    = 120;
        $timeLiveRefresh = 60 * 24 * 7;

        JWTAuth::factory()->setTTL($timeLiveToken);
        $accessToken = JWTAuth::fromUser($user);

        JWTAuth::factory()->setTTL($timeLiveRefresh);
        $refreshToken = JWTAuth::customClaims(['jwt_refresh' => true])->fromUser($user);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $user,
        ], $status)
            ->withCookie($this->buildCookie('jwt_token', $accessToken, $timeLiveToken))
            ->withCookie($this->buildCookie('jwt_refresh', $refreshToken, $timeLiveRefresh));
    }

    private function buildCookie(string $name, string $value, int $minutes): Cookie
    {
        $httpOnly = true;

        if (env('APP_ENV') === 'production') {
            $secure = true;
            $sameSite = 'None';
            $domain = env('COOKIE_DOMAIN_PROD');
        } else {
            $secure = false;
            $sameSite = 'Lax';
            $domain = null;
        }

        return cookie(
            $name,
            $value,
            $minutes,
            '/',
            $domain,
            $secure,
            $httpOnly,
            false,
            $sameSite
        );
    }

    private function clearCookie(string $name)
    {
        if (env('APP_ENV') === 'production') {
            $secure = true;
            $sameSite = 'None';
            $domain = env('COOKIE_DOMAIN_PROD');
        } else {
            $secure = false;
            $sameSite = 'Lax';
            $domain = null;
        }

        return cookie(
            $name,
            '',
            -1,
            '/',
            $domain,
            $secure,
            true,
            false,
            $sameSite
        );
    }
}
