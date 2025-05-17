<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Loaidonvi
 * 
 * @property int $id
 * @property string $tenloai
 * 
 * @property Collection|Donvi[] $donvis
 *
 * @package App\Models
 */
class Loaidonvi extends Model
{
	protected $table = 'loaidonvi';
	public $timestamps = false;

	protected $fillable = [
		'tenloai'
	];

	public function donvis()
	{
		return $this->hasMany(Donvi::class, 'maloai');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($loaidonvi) {
			$loaidonvi->donvis()->delete();
		});
	}
}
