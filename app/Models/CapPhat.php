<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Capphat
 * 
 * @property int $id
 * @property string $maHP
 * @property string $tenHP
 * @property string $maLop
 * @property int $siSo
 * @property int $id_gv
 * @property string $file_cap
 * @property string $file_xacnhan
 * @property int $id_hocky
 * 
 * @property Taikhoan $taikhoan
 * @property Hocphan $hocphan
 * @property Hocky $hocky
 *
 * @package App\Models
 */
class Capphat extends Model
{
	protected $table = 'capphat';
	public $timestamps = false;

	protected $casts = [
		'siSo' => 'int',
		'id_gv' => 'int',
		'id_hocky' => 'int'
	];

	protected $fillable = [
		'maHP',
		'tenHP',
		'maLop',
		'siSo',
		'id_gv',
		'file_cap',
		'file_xacnhan',
		'id_hocky'
	];

	public function taikhoan()
	{
		return $this->belongsTo(Taikhoan::class, 'id_gv');
	}

	public function hocphan()
	{
		return $this->belongsTo(Hocphan::class, 'maHP');
	}

	public function hocky()
	{
		return $this->belongsTo(Hocky::class, 'id_hocky');
	}
}
