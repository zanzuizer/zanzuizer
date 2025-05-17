<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Soquanlykho
 * 
 * @property int $id
 * @property int $maphong
 * @property int $matk
 * @property int $mahocky
 * @property int $matb
 * @property string $ngaymuon
 * @property string|null $ngaytra
 * @property string $mucdichsd
 * @property string $tinhtrangtruoc
 * @property string|null $tinhtrangsau
 * @property int $ngaytao
 * @property int $ngaycapnhat
 * 
 * @property Hocky $hocky
 * @property Maymocthietbi $maymocthietbi
 * @property PhongKho $phong_kho
 * @property Taikhoan $taikhoan
 *
 * @package App\Models
 */
class Soquanlykho extends Model
{
	protected $table = 'soquanlykho';
	public $timestamps = false;

	protected $casts = [
		'maphong' => 'int',
		'matk' => 'int',
		'mahocky' => 'int',
		'matb' => 'int',
		'ngaytao' => 'int',
		'ngaycapnhat' => 'int'
	];

	protected $fillable = [
		'maphong',
		'matk',
		'mahocky',
		'matb',
		'ngaymuon',
		'ngaytra',
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

	public function maymocthietbi()
	{
		return $this->belongsTo(Maymocthietbi::class, 'matb');
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
