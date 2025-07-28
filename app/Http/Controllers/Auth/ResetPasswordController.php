<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Base64Url;
use App\Http\Controllers\Controller;
use App\Traits\HandlesCookies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Carbon;

class ResetPasswordController extends Controller
{
    use HandlesCookies;
    public function checkToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);
        $tokenDecode = Base64Url::decode($request->token);
        $data = json_decode($tokenDecode, true);
        $email = $data['email'] ?? "";
        $token = $data['token'] ?? "";

        // Lấy token từ bảng password_reset_tokens
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Không tìm thấy token.'], 404);
        }

        // So sánh token (đã hash trong DB) với token người dùng gửi
        if (!Hash::check($token, $record->token)) {
            return response()->json(['message' => 'Token không hợp lệ.'], 401);
        }

        // Kiểm tra thời gian hết hạn
        $expireMinutes = config('auth.passwords.users.expire', 15); // Mặc định là 15 phút
        $createdAt = Carbon::parse($record->created_at);

        if ($createdAt->addMinutes($expireMinutes)->isPast()) {
            return response()->json(['message' => 'Token đã hết hạn.'], 410);
        }

        return response()->json(['message' => 'Token hợp lệ.'], 200);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'string|required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password)  use (&$intanceUser) {
                $user->forceFill([
                    'password' => $password,
                ])->save();
                $intanceUser = $user;
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->respondWithToken($intanceUser, 'Đăng nhập thành công!', 200);
        }

        return response()->json(['message' => __($status)], 400);
    }
}
