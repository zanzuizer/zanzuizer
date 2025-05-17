<?php

namespace App\Services;

use App\Models\LoginLog;
use Illuminate\Http\Request;

class LoginLogService
{
    /**
     * Ghi log đăng nhập
     *
     * @param Request $request
     * @param bool $status
     * @param int|null $userId
     * @param string|null $email
     * @param string|null $notes
     * @return LoginLog
     */
    public function log(Request $request, bool $status, ?int $userId = null, ?string $email = null, ?string $notes = null)
    {
        // Xác định loại thiết bị đơn giản dựa trên user agent
        $userAgent = $request->userAgent();
        $device = 'Unknown';
        
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
            $device = 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
            $device = 'Tablet';
        } else {
            $device = 'Desktop';
        }

        // Tạo log
        return LoginLog::createLog([
            'user_id' => $userId,
            'email' => $email ?: $request->input('email'),
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'device' => $device,
            'status' => $status,
            'notes' => $notes
        ]);
    }
}