<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DanhmucMuasam
 * 
 * @property int $id
 * @property string $ten_danhmuc
 * @property Carbon|null $lock_start_date
 * @property Carbon|null $lock_end_date
 * @property bool|null $is_locked
 * 
 * @property Collection|DeNghi[] $de_nghis
 *
 * @package App\Models
 */
class DanhmucMuasam extends Model
{
	protected $table = 'danhmuc_muasam';
	public $timestamps = false;

	protected $casts = [
		'lock_start_date' => 'datetime',
		'lock_end_date' => 'datetime',
		'is_locked' => 'bool'
	];

	protected $fillable = [
		'ten_danhmuc',
		'lock_start_date',
		'lock_end_date',
		'is_locked'
	];

	public function de_nghis()
	{
		return $this->hasMany(DeNghi::class, 'id_danhmuc');
	}

	public static function boot()
	{
		parent::boot();
		static::deleting(function ($danhmuc) {
			$danhmuc->de_nghis()->delete();
		});
	}
}
