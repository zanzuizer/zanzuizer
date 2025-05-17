<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Nhommaymocthietbi
 * 
 * @property int $id
 * @property string $tennhom
 * 
 * @property Collection|Maymocthietbi[] $maymocthietbis
 *
 * @package App\Models
 */
class Nhommaymocthietbi extends Model
{
	protected $table = 'nhommaymocthietbi';
	public $timestamps = false;

	protected $fillable = [
		'tennhom'
	];

	public function maymocthietbis()
	{
		return $this->hasMany(Maymocthietbi::class, 'manhom');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($nhommaymocthietbi) {
			$nhommaymocthietbi->maymocthietbis()->delete();
		});
	}
}
