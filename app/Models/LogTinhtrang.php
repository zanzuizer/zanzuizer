<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogTinhtrang
 * 
 * @property int $id
 * @property int|null $matb
 * @property string|null $ghichu
 * @property int|null $ngaytao
 * @property int|null $matk
 * 
 * @property Taikhoan|null $taikhoan
 *
 * @package App\Models
 */
class LogTinhtrang extends Model
{
	protected $table = 'log_tinhtrang';
	public $timestamps = false;

	protected $casts = [
		'matb' => 'int',
		'ngaytao' => 'int',
		'matk' => 'int'
	];

	protected $fillable = [
		'matb',
		'ghichu',
		'ngaytao',
		'matk'
	];

	public function taikhoan()
	{
		return $this->belongsTo(Taikhoan::class, 'matk');
	}
}
