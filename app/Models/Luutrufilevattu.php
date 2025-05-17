<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Luutrufilevattu
 * 
 * @property int $id
 * @property string $tenfile
 * @property string $tengv
 * @property int $id_hocky
 * 
 * @property Hocky $hocky
 *
 * @package App\Models
 */
class Luutrufilevattu extends Model
{
	protected $table = 'luutrufilevattu';
	public $timestamps = false;

	protected $casts = [
		'id_hocky' => 'int'
	];

	protected $fillable = [
		'tenfile',
		'tengv',
		'id_hocky'
	];

	public function hocky()
	{
		return $this->belongsTo(Hocky::class, 'id_hocky');
	}
}
