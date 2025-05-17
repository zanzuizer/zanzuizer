<?php

namespace App\Services;

use App\Models\Taikhoan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class AuthService
{
    /**
     * Xác thực người dùng và tạo token JWT.
     *
     * @param string $email
     * @param string $password
     * @param bool $checkRateLimit Có kiểm tra giới hạn đăng nhập không
     * @param string|null $rateLimitKey Key để kiểm tra giới hạn đăng nhập
     * @param Request|null $request Request hiện tại để ghi log
     * @return array
     */
    public function authenticate($email, $password, $checkRateLimit = false, $rateLimitKey = null, Request $request = null)
    {
        // Kiểm tra giới hạn đăng nhập nếu cần
        if ($checkRateLimit && $rateLimitKey) {
            if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
                $seconds = RateLimiter::availableIn($rateLimitKey);

                // Ghi log đăng nhập thất bại do rate limit
                if ($request) {
                    Log::channel('login')->warning('Đăng nhập bị chặn do vượt quá số lần thử', [
                        'email' => $email,
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'seconds_remaining' => $seconds,
                        'time' => now()->format('Y-m-d H:i:s')
                    ]);
                }

                return [
                    'success' => false,
                    'message' => "Bạn đã nhập sai quá nhiều lần. Thử lại sau $seconds giây.",
                    'rate_limited' => true,
                    'seconds' => $seconds
                ];
            }
        }

        // Thực hiện đăng nhập
        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        // Thử đăng nhập với guard mặc định
        if (Auth::attempt($credentials)) {
            // Đăng nhập thành công, xóa rate limit nếu có
            if ($checkRateLimit && $rateLimitKey) {
                RateLimiter::clear($rateLimitKey);
            }

            // Tạo JWT token
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);

            // Ghi log đăng nhập thành công
            if ($request) {
                Log::channel('login')->info('Đăng nhập thành công qua web', [
                    'user_id' => $user->id,
                    'email' => $email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'time' => now()->format('Y-m-d H:i:s')
                ]);
            }

            return [
                'success' => true,
                'user' => $user,
                'token' => $token
            ];
        }

        // Thử đăng nhập với guard API
        if (Auth::guard('api')->attempt($credentials)) {
            // Đăng nhập thành công, xóa rate limit nếu có
            if ($checkRateLimit && $rateLimitKey) {
                RateLimiter::clear($rateLimitKey);
            }

            // Lấy token từ guard API
            $token = Auth::guard('api')->attempt($credentials);
            $user = Auth::guard('api')->user();

            // Ghi log đăng nhập thành công
            if ($request) {
                Log::channel('login')->info('Đăng nhập thành công qua API', [
                    'user_id' => $user->id,
                    'email' => $email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'time' => now()->format('Y-m-d H:i:s')
                ]);
            }

            return [
                'success' => true,
                'user' => $user,
                'token' => $token
            ];
        }

        // Đăng nhập thất bại, tăng rate limit nếu có
        if ($checkRateLimit && $rateLimitKey) {
            RateLimiter::hit($rateLimitKey, 60);
        }

        // Ghi log đăng nhập thất bại
        if ($request) {
            Log::channel('login')->warning('Đăng nhập thất bại: Email hoặc mật khẩu không đúng', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'time' => now()->format('Y-m-d H:i:s')
            ]);
        }

        return [
            'success' => false,
            'message' => 'Email hoặc mật khẩu không đúng.'
        ];
    }

    /**
     * Tạo cấu trúc token JWT để trả về.
     *
     * @param string $token
     * @return array
     */
    public function createTokenResponse($token)
    {
        $user = Auth::guard('api')->user();

        // Ghi log tạo token
        Log::channel('login')->info('Token JWT được tạo cho người dùng', [
            'user_id' => $user->id,
            'email' => $user->email,
            'time' => now()->format('Y-m-d H:i:s')
        ]);

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60, // Get TTL from config
            'user' => $user
        ];
    }
}
