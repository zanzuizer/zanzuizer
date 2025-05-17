<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Taikhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    /**
     * Tạo một instance mới của controller.
     *
     * @return void
     */
    public function __construct()
    {
        // Authentication is handled in the routes/api.php file
    }

    /**
     * Xác thực người dùng và tạo token JWT.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'matkhau' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Sử dụng AuthService để xác thực
        $authService = app(\App\Services\AuthService::class);
        $result = $authService->authenticate($request->email, $request->matkhau, false, null, $request);

        if ($result['success']) {
            // Đăng nhập thành công
            return response()->json($authService->createTokenResponse($result['token']));
        } else {
            // Đăng nhập thất bại
            return response()->json(['error' => $result['message']], 401);
        }
    }

    /**
     * Lấy thông tin người dùng đã đăng nhập.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Đăng xuất người dùng (vô hiệu hóa token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Lấy thông tin người dùng trước khi đăng xuất
        $user = Auth::guard('api')->user();

        // Ghi log đăng xuất nếu có người dùng đăng nhập
        if ($user) {
            Log::channel('login')->info('Đăng xuất API thành công', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'time' => now()->format('Y-m-d H:i:s')
            ]);
        }

        Auth::guard('api')->logout();

        return response()->json(['message' => 'Đăng xuất thành công']);
    }

    /**
     * Làm mới token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            // Sử dụng JWTAuth facade để làm mới token
            $newToken = JWTAuth::parseToken()->refresh();

            return $this->respondWithToken($newToken);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể làm mới token. Vui lòng đăng nhập lại.'], 401);
        }
    }

    /**
     * Gửi email reset mật khẩu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:taikhoan,email'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        Mail::send('emails.reset-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return response()->json(['message' => 'Chúng tôi đã gửi link reset mật khẩu qua email của bạn!']);
    }

    /**
     * Reset mật khẩu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'matkhau' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return response()->json(['error' => 'Token không hợp lệ hoặc đã hết hạn!'], 400);
        }

        $user = Taikhoan::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'Không tìm thấy tài khoản tương ứng!'], 404);
        }

        // Cập nhật mật khẩu đã được mã hóa
        $user->matkhau = Hash::make($request->matkhau);
        $user->save();

        // Xóa token sau khi reset xong
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Mật khẩu của bạn đã được thay đổi thành công!']);
    }

    /**
     * Trả về cấu trúc token JWT.
     *
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60, // Get TTL from config
            'user' => Auth::guard('api')->user()
        ]);
    }
}
