<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Loaitaikhoan
 * 
 * @property int $id
 * @property string|null $tenloai
 * @property string|null $mota
 * 
 * @property Collection|Taikhoan[] $taikhoans
 *
 * @package App\Models
 */
class Loaitaikhoan extends Model
{
	protected $table = 'loaitaikhoan';
	public $timestamps = false;

	protected $fillable = [
		'tenloai',
		'mota'
	];

	public function taikhoans()
	{
		return $this->hasMany(Taikhoan::class, 'maloaitk');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($loaitaikhoan) {
			$loaitaikhoan->taikhoans()->delete();
		});
	}
}
