<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Base64Url;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Traits\HandlesCookies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Carbon;

class ResetPasswordController extends BaseApiController
{
    use HandlesCookies;
    public function checkToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $plainToken = $request->input('token');

        // Lấy tất cả bản ghi để so sánh vì token trong DB đã được mã hóa
        $records = DB::table('password_reset_tokens')->get();

        $record = null;

        foreach ($records as $r) {
            if (Hash::check($plainToken, $r->token)) {
                $record = $r;
                break;
            }
        }

        if (!$record) {
            return $this->errorResponse('Token không hợp lệ.', 401);
        }

        // Kiểm tra thời gian hết hạn
        $expireMinutes = config('auth.passwords.users.expire', 60); // thường là 60 phút
        $createdAt = Carbon::parse($record->created_at);

        if ($createdAt->addMinutes($expireMinutes)->isPast()) {
            return $this->errorResponse('Token đã hết hạn.', 410);
        }

        return $this->successResponse([
            'email' => $record->email
        ], 200);
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

        return $this->errorResponse(__($status), 400);
    }
}
