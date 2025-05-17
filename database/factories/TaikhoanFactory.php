<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Taikhoan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Taikhoan>
 */
class TaikhoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Taikhoan::class;

    protected static ?string $matkhau;

    public function definition(): array
    {
        return [
            'hoten'     => $this->faker->name(),
            'email'     => $this->faker->unique()->safeEmail(),
            'matkhau'   => static::$matkhau ??= bcrypt('123456'),
            'cmnd'      => $this->faker->unique()->numerify('############'),
            'maloaitk'  => $this->faker->numberBetween(1, 3),
            'madonvi'   => $this->faker->numberBetween(1, 3),
            'chucvu'    => $this->faker->randomElement(['Giảng Viên', 'Quản trị viên']),
            'hinhanh'   => $this->faker->imageUrl()
        ];
    }
}
