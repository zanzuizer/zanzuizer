<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nhatkytungtb
 * 
 * @property int $id
 * @property int $idtb
 * @property string $ngay
 * @property string $giovao
 * @property string $giora
 * @property string $mucdichsd
 * @property string $tinhtrangtruoc
 * @property string $tinhtrangsau
 * @property int $ngaytao
 * @property int $maphong
 * @property int $matk
 * @property int $ma_namsd
 * 
 * @property NhatkytungtbNamsd $nhatkytungtb_namsd
 * @property PhongKho $phong_kho
 * @property Taikhoan $taikhoan
 *
 * @package App\Models
 */
class Nhatkytungtb extends Model
{
	protected $table = 'nhatkytungtb';
	public $timestamps = false;

	protected $casts = [
		'idtb' => 'int',
		'ngaytao' => 'int',
		'maphong' => 'int',
		'matk' => 'int',
		'ma_namsd' => 'int'
	];

	protected $fillable = [
		'idtb',
		'ngay',
		'giovao',
		'giora',
		'mucdichsd',
		'tinhtrangtruoc',
		'tinhtrangsau',
		'ngaytao',
		'maphong',
		'matk',
		'ma_namsd'
	];

	public function nhatkytungtb_namsd()
	{
		return $this->belongsTo(NhatkytungtbNamsd::class, 'ma_namsd');
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
