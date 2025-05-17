<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Loaimaymocthietbi
 * 
 * @property int $id
 * @property string $tenloai
 * 
 * @property Collection|Maymocthietbi[] $maymocthietbis
 *
 * @package App\Models
 */
class Loaimaymocthietbi extends Model
{
	protected $table = 'loaimaymocthietbi';
	public $timestamps = false;

	protected $fillable = [
		'tenloai'
	];

	public function maymocthietbis()
	{
		return $this->hasMany(Maymocthietbi::class, 'maloai');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($loaimaymocthietbi) {
			$loaimaymocthietbi->maymocthietbis()->delete();
		});
	}
}
