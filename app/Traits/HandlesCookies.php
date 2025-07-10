<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Cookie;

trait HandlesCookies
{
    /**
     * Tạo cookie httpOnly
     */
    private function buildCookie(string $name, string $value, int $minutes): Cookie
    {
        return cookie(
            $name,
            $value,
            $minutes,
            '/',
            null,
            true,
            true
        );
    }

    /**
     * Tạo cookie xóa (thời gian sống -1 phút)
     */
    private function clearCookie(string $name)
    {
        return cookie($name, '', -1, '/', null, true, true);
    }
}
