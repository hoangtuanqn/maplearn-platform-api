<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Nếu chưa đăng nhập
        if (!$user) {
            return response()->json(['message' => 'Bạn chưa đăng nhập!'], 401);
        }

        // Nếu không phải admin hoặc teacher
        if (!in_array($user->role, ['admin', 'teacher'])) {
            return response()->json(['message' => 'Bạn không có quyền để truy cập vào trang này!'], 403);
        }

        return $next($request);
    }
}
