<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NhatkytungtbNamsd
 * 
 * @property int $id
 * @property int $namsd
 * @property string $ngaytao
 * 
 * @property Collection|Nhatkytungtb[] $nhatkytungtbs
 *
 * @package App\Models
 */
class NhatkytungtbNamsd extends Model
{
	protected $table = 'nhatkytungtb_namsd';
	public $timestamps = false;

	protected $casts = [
		'namsd' => 'int'
	];

	protected $fillable = [
		'namsd',
		'ngaytao'
	];

	public function nhatkytungtbs()
	{
		return $this->hasMany(Nhatkytungtb::class, 'ma_namsd');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($nhatkytungtbNamsd) {
			$nhatkytungtbNamsd->nhatkytungtbs()->delete();
		});
	}
}
