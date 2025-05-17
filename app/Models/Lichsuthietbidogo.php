<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lichsuthietbidogo
 * 
 * @property int $id
 * @property string $noidung
 * @property Carbon $ngay
 * @property int $matbdg
 * 
 * @property Thietbidogo $thietbidogo
 *
 * @package App\Models
 */
class Lichsuthietbidogo extends Model
{
	protected $table = 'lichsuthietbidogo';
	public $timestamps = false;

	protected $casts = [
		'ngay' => 'datetime',
		'matbdg' => 'int'
	];

	protected $fillable = [
		'noidung',
		'ngay',
		'matbdg'
	];

	public function thietbidogo()
	{
		return $this->belongsTo(Thietbidogo::class, 'matbdg');
	}
}
