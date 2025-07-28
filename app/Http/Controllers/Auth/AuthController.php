<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HandlesCookies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use HandlesCookies;

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $validator->safe()->only('username', 'password');

        if (!JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Thông tin đăng nhập chưa chính xác!'], 401);
        }

        // Lấy user từ token
        $user = JWTAuth::user();
        // Xử lý nếu bật 2FA
        if ($user->google2fa_secret) {
            return response()->json([
                'message' => "Vui lòng nhập mã xác thực 2Fa để tiếp tục!",
                '2fa_required' => true,
                'user_id' => $user->id,
                // Thêm salt vào token
                'token' => base64_encode(JWTAuth::fromUser($user) . env('T1_SECRET', "")),
            ]);
        }
        // logger("Login user >> " . $user);

        // Trả về token + refresh token dưới dạng cookie
        return $this->respondWithToken($user, 'Đăng nhập thành công!');
    }

    /**
     * Xử lý đăng ký
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'username' => 'required|string|unique:users|max:255',
            'password' => 'required|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->safe()->toArray();
        $user = User::create($data);

        // Tạo cookie token và trả về response
        return $this->respondWithToken($user, 'Đã đăng ký tài khoản thành công!', 201);
    }

    /**
     * Refresh token khi token cũ đã hết hạn
     */
    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->cookie('jwt_refresh');
            if (!$refreshToken) {
                return response()->json(['error' => 'Mã refresh token không tồn tại!'], 401);
            }

            JWTAuth::setToken($refreshToken);
            $payload = JWTAuth::getPayload();

            if (!$payload->get('jwt_refresh')) {
                return response()->json(['error' => 'Refresh token không hợp lệ!'], 401);
            }

            $user = JWTAuth::authenticate();

            // Cấp lại token mới
            return $this->respondWithToken($user, 'Làm mới token thành công!');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Không thể làm mới token! Vui lòng thử lại!',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Lấy thông tin người dùng hiện tại
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin người dùng thành công!',
            'data' => $request->user(),
        ]);
    }


    /**
     * Xác thực mã 2Fa của người dùng
     */
    public function verify2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'otp' => 'required|digits:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $token = base64_decode($request->token);
        // Kiểm tra salt phải nằm trong token
        if (!str_contains($token, env('T1_SECRET', ""))) {
            return response()->json(['success' => false, 'message' => 'Token Invalid!'], 401);
        }
        // Xóa salt ra khỏi token
        $token = str_replace(env('T1_SECRET'), "", $token);
        JWTAuth::setToken($token);
        $user = JWTAuth::authenticate();
        if (!$user->google2fa_secret) {
            return response()->json(['success' => false, 'message' => 'Tài khoản này chưa bật xác thực 2 lớp!'], 401);
        }
        $google2fa = new Google2FA();
        $isValid = $google2fa->verifyKey(
            $user->google2fa_secret,
            $request->otp
        );

        if (!$isValid) {
            return response()->json(['success' => false, 'message' => 'Mã OTP chính xác hoặc đã hết hạn!'], 401);
        }
        return $this->respondWithToken($user, 'Xác thực tài khoản thành công!');
    }


    /**
     * Đăng xuất: Xóa cookie
     */
    public function logout()
    {
        return response()->json([
            'success' => true,
            'message' => 'Đăng xuất thành công!'
        ])->withCookie($this->clearCookie('jwt_token'))
            ->withCookie($this->clearCookie('jwt_refresh'));
    }
}
