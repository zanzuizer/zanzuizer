<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Hocphan
 * 
 * @property string $maHP
 * @property string $tenHP
 * 
 * @property Collection|CapPhat[] $cap_phats
 * @property Collection|Capphat[] $capphats
 * @property Collection|Vattu[] $vattus
 *
 * @package App\Models
 */
class Hocphan extends Model
{
	protected $table = 'hocphan';
	protected $primaryKey = 'maHP';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'tenHP'
	];

	public function cap_phats()
	{
		return $this->hasMany(CapPhat::class, 'ma_hoc_phan');
	}

	public function capphats()
	{
		return $this->hasMany(Capphat::class, 'maHP');
	}

	public function vattus()
	{
		return $this->hasMany(Vattu::class, 'maHP');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($hocphan) {
			$hocphan->cap_phats()->delete();
			$hocphan->capphats()->delete();
			$hocphan->vattus()->delete();
		});
	}
}
