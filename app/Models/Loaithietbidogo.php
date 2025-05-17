<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Loaithietbidogo
 * 
 * @property int $id
 * @property string $tenloai
 * 
 * @property Collection|Thietbidogo[] $thietbidogos
 *
 * @package App\Models
 */
class Loaithietbidogo extends Model
{
	protected $table = 'loaithietbidogo';
	public $timestamps = false;

	protected $fillable = [
		'tenloai'
	];

	public function thietbidogos()
	{
		return $this->hasMany(Thietbidogo::class, 'maloai');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($loaithietbidogo) {
			$loaithietbidogo->thietbidogos()->delete();
		});
	}
}
