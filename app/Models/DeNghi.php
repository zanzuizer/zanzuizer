<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeNghi
 * 
 * @property int $id
 * @property string $ten_de_nghi
 * @property string $mo_ta
 * @property int $id_hocky
 * @property int $id_nguoitao
 * @property int $id_danhmuc
 * 
 * @property DanhmucMuasam $danhmuc_muasam
 * @property Hocky $hocky
 * @property Taikhoan $taikhoan
 * @property Collection|LuutruTaptin[] $luutru_taptins
 *
 * @package App\Models
 */
class DeNghi extends Model
{
	protected $table = 'de_nghi';
	public $timestamps = false;

	protected $casts = [
		'id_hocky' => 'int',
		'id_nguoitao' => 'int',
		'id_danhmuc' => 'int'
	];

	protected $fillable = [
		'ten_de_nghi',
		'mo_ta',
		'id_hocky',
		'id_nguoitao',
		'id_danhmuc'
	];

	public function danhmuc_muasam()
	{
		return $this->belongsTo(DanhmucMuasam::class, 'id_danhmuc');
	}

	public function hocky()
	{
		return $this->belongsTo(Hocky::class, 'id_hocky');
	}

	public function taikhoan()
	{
		return $this->belongsTo(Taikhoan::class, 'id_nguoitao');
	}

	public function luutru_taptins()
	{
		return $this->hasMany(LuutruTaptin::class, 'id_denghi');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($denghi) {
			$denghi->luutru_taptins()->delete();
		});
	}
}
