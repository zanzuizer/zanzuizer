<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nhatkyphongmay
 * 
 * @property int $id
 * @property int $maphong
 * @property int $matk
 * @property int $mahocky
 * @property string $ngay
 * @property string $giovao
 * @property string $giora
 * @property string $mucdichsd
 * @property string $tinhtrangtruoc
 * @property string $tinhtrangsau
 * @property int $ngaytao
 * @property int|null $ngaycapnhat
 * 
 * @property Hocky $hocky
 * @property PhongKho $phong_kho
 * @property Taikhoan $taikhoan
 *
 * @package App\Models
 */
class Nhatkyphongmay extends Model
{
	protected $table = 'nhatkyphongmay';
	public $timestamps = false;

	protected $casts = [
		'maphong' => 'int',
		'matk' => 'int',
		'mahocky' => 'int',
		'ngaytao' => 'int',
		'ngaycapnhat' => 'int'
	];

	protected $fillable = [
		'maphong',
		'matk',
		'mahocky',
		'ngay',
		'giovao',
		'giora',
		'mucdichsd',
		'tinhtrangtruoc',
		'tinhtrangsau',
		'ngaytao',
		'ngaycapnhat'
	];

	public function hocky()
	{
		return $this->belongsTo(Hocky::class, 'mahocky');
	}

	public function phong_kho()
	{
		return $this->belongsTo(PhongKho::class, 'maphong');
	}

	public function taikhoan()
	{
		return $this->belongsTo(Taikhoan::class, 'matk');
	}
}
