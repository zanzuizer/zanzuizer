<?php

namespace Database\Seeders;

use App\Models\Taikhoan;
use Illuminate\Container\Attributes\Auth;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Taikhoan::factory()->create([
            'hoten' => 'Trịnh Khắc Nhựt',
            'email' => 'khacnhut2004vlg@gmail.com',
            'matkhau' => Hash::make("Admin@123"), // Mật khẩu đã được mã hóa
            'maloaitk' => 1,
            'madonvi' => 1,
            'chucvu' => 'Giảng Viên',
            'hinhanh' => 'default.png'
        ]);
    }
}
