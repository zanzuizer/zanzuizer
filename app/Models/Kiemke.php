<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Kiemke
 * 
 * @property int $id
 * @property string $ten_tb
 * @property string $maso
 * @property int $namsx
 * @property string $hientrang
 * @property string $nd_baotri
 * @property string $tg_baotri
 * @property Carbon $tg_thuchien
 * @property string $dv_thuchien
 * @property string $ghichu
 * @property int $id_phong
 * @property int $id_hocky
 * @property int $id_nguoitao
 * 
 * @property Hocky $hocky
 * @property Taikhoan $taikhoan
 * @property PhongKho $phong_kho
 *
 * @package App\Models
 */
class Kiemke extends Model
{
	protected $table = 'kiemke';
	public $timestamps = false;

	protected $casts = [
		'namsx' => 'int',
		'tg_thuchien' => 'datetime',
		'id_phong' => 'int',
		'id_hocky' => 'int',
		'id_nguoitao' => 'int'
	];

	protected $fillable = [
		'ten_tb',
		'maso',
		'namsx',
		'hientrang',
		'nd_baotri',
		'tg_baotri',
		'tg_thuchien',
		'dv_thuchien',
		'ghichu',
		'id_phong',
		'id_hocky',
		'id_nguoitao'
	];

	public function hocky()
	{
		return $this->belongsTo(Hocky::class, 'id_hocky');
	}

	public function taikhoan()
	{
		return $this->belongsTo(Taikhoan::class, 'id_nguoitao');
	}

	public function phong_kho()
	{
		return $this->belongsTo(PhongKho::class, 'id_phong');
	}
}
