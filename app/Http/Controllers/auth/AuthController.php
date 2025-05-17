<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Taikhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('matkhau');
        $key = 'login-attempts:' . $email;

        // Sử dụng AuthService để xác thực
        $authService = app(\App\Services\AuthService::class);
        $result = $authService->authenticate($email, $password, true, $key, $request);

        if ($result['success']) {
            // Đăng nhập thành công
            $request->session()->regenerate();

            // Lưu token vào session để sử dụng sau này
            session(['jwt_token' => $result['token']]);

            return redirect()->intended('/home');
        } else {
            // Đăng nhập thất bại
            if (isset($result['rate_limited']) && $result['rate_limited']) {
                return back()->withErrors(['email' => $result['message']]);
            }

            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:taikhoan,email'
        ]);

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

        return back()->with('status', 'Chúng tôi đã gửi link reset mật khẩu qua email của bạn!');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'matkhau' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withInput()->with('error', 'Token không hợp lệ hoặc đã hết hạn!');
        }

        $user = Taikhoan::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Không tìm thấy tài khoản tương ứng!');
        }

        // Cập nhật mật khẩu đã được mã hóa
        $user->matkhau = Hash::make($request->matkhau);
        $user->save();

        // Xóa token sau khi reset xong
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Mật khẩu của bạn đã được thay đổi thành công!');
    }

    public function logout(Request $request)
    {
        // Lấy thông tin người dùng trước khi đăng xuất
        $user = Auth::user();

        // Vô hiệu hóa JWT token nếu có
        if (session()->has('jwt_token')) {
            try {
                JWTAuth::setToken(session('jwt_token'))->invalidate();
            } catch (\Exception $e) {
                // Xử lý nếu token không hợp lệ
            }
            session()->forget('jwt_token');
        }

        // Ghi log đăng xuất nếu có người dùng đăng nhập
        if ($user) {
            Log::channel('login')->info('Đăng xuất thành công', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'time' => now()->format('Y-m-d H:i:s')
            ]);
        }

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login');
    }
}
