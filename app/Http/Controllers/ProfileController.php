<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->user()->update($request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'gender' => 'sometimes|string|in:male,female,other',
            'birth_year' => 'sometimes|nullable',
            'school' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'facebook_link' => 'sometimes|string|max:255',
        ]));

        return response()->json([
            'message' => $request->user(),
        ]);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'password_old' => 'required|string|max:255',
            'password_new' => 'required|string|min:6|max:255',
        ]);

        $user = $request->user();

        // Kiểm tra mật khẩu cũ có đúng không
        if (!Hash::check($request->password_old, $user->password)) {
            return response()->json([
                'message' => 'Mật khẩu cũ không chính xác.',
            ], 401);
        }

        // Cập nhật mật khẩu mới (đã hash)
        $user->update([
            'password' => Hash::make($request->password_new),
        ]);

        return response()->json([
            'message' => 'Đổi mật khẩu thành công.',
        ]);
    }
}
