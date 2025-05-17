<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    protected $table = 'login_logs';

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'user_agent',
        'device',
        'status',
        'notes'
    ];

    /**
     * Lấy thông tin người dùng liên quan đến log đăng nhập
     */
    public function user()
    {
        return $this->belongsTo(Taikhoan::class, 'user_id');
    }

    /**
     * Phương thức để tạo log đăng nhập
     *
     * @param array $data
     * @return LoginLog
     */
    public static function createLog(array $data)
    {
        return self::create($data);
    }
}