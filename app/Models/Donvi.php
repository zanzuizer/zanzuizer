<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donvi
 * 
 * @property int $id
 * @property string|null $tendonvi
 * @property string|null $tenviettat
 * @property int $maloai
 * 
 * @property Loaidonvi $loaidonvi
 * @property Collection|Hocky[] $hockies
 * @property Collection|PhongKho[] $phong_khos
 * @property Collection|Taikhoan[] $taikhoans
 *
 * @package App\Models
 */
class Donvi extends Model
{
	protected $table = 'donvi';
	public $timestamps = false;

	protected $casts = [
		'maloai' => 'int'
	];

	protected $fillable = [
		'tendonvi',
		'tenviettat',
		'maloai'
	];

	public function loaidonvi()
	{
		return $this->belongsTo(Loaidonvi::class, 'maloai');
	}

	public function hockies()
	{
		return $this->hasMany(Hocky::class, 'madonvi');
	}

	public function phong_khos()
	{
		return $this->hasMany(PhongKho::class, 'madonvi');
	}

	public function taikhoans()
	{
		return $this->hasMany(Taikhoan::class, 'madonvi');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($donvi) {
			$donvi->taikhoans()->delete();
			$donvi->phong_khos()->delete();
			$donvi->hockies()->delete();
		});
	}
}
