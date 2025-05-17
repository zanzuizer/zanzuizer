<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nhatkyqlphong
 * 
 * @property int $id
 * @property int $magvql
 * @property int $maphong
 * @property int $mahocky
 * 
 * @property Taikhoan $taikhoan
 * @property Hocky $hocky
 * @property PhongKho $phong_kho
 *
 * @package App\Models
 */
class Nhatkyqlphong extends Model
{
	protected $table = 'nhatkyqlphong';
	public $timestamps = false;

	protected $casts = [
		'magvql' => 'int',
		'maphong' => 'int',
		'mahocky' => 'int'
	];

	protected $fillable = [
		'magvql',
		'maphong',
		'mahocky'
	];

	public function taikhoan()
	{
		return $this->belongsTo(Taikhoan::class, 'magvql');
	}

	public function hocky()
	{
		return $this->belongsTo(Hocky::class, 'mahocky');
	}

	public function phong_kho()
	{
		return $this->belongsTo(PhongKho::class, 'maphong');
	}
}
