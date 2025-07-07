<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

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
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:6',
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
     * Refresh token từ cookie jwt_refresh
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

    /**
     * Hàm tái sử dụng: Tạo token và trả về response kèm cookie
     */
    private function respondWithToken(User $user, string $message, int $status = 200)
    {
        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = JWTAuth::customClaims(['jwt_refresh' => true])->fromUser($user);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $user,
        ], $status)
            ->withCookie($this->buildCookie('jwt_token', $accessToken, 15))
            ->withCookie($this->buildCookie('jwt_refresh', $refreshToken, 60 * 24 * 7));
    }

    /**
     * Tạo cookie httpOnly
     */
    private function buildCookie(string $name, string $value, int $minutes)
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
