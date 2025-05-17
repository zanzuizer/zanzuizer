<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tinhtrangthietbi
 * 
 * @property int $id
 * @property string $tinhtrang
 * @property string|null $mota
 * 
 * @property Collection|Maymocthietbi[] $maymocthietbis
 * @property Collection|Thietbidogo[] $thietbidogos
 *
 * @package App\Models
 */
class Tinhtrangthietbi extends Model
{
	protected $table = 'tinhtrangthietbi';
	public $timestamps = false;

	protected $fillable = [
		'tinhtrang',
		'mota'
	];

	public function maymocthietbis()
	{
		return $this->hasMany(Maymocthietbi::class, 'matinhtrang');
	}

	public function thietbidogos()
	{
		return $this->hasMany(Thietbidogo::class, 'matinhtrang');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($tinhtrangthietbi) {
			$tinhtrangthietbi->maymocthietbis()->delete();
			$tinhtrangthietbi->thietbidogos()->delete();
		});
	}
}
