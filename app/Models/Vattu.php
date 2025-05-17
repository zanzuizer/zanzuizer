<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vattu
 * 
 * @property int $id
 * @property string|null $ten
 * @property string|null $dvt
 * @property int|null $soluong
 * @property string|null $dongia
 * @property string|null $khaitoan
 * @property string|null $dinhmuc
 * @property string|null $mahieu
 * @property string|null $nhanhieu
 * @property int|null $namsx
 * @property string|null $xuatxu
 * @property string|null $hangsx
 * @property string|null $cauhinh
 * @property string $maHP
 * @property string $caTH
 * @property int $id_hocky
 * 
 * @property Hocky $hocky
 * @property Hocphan $hocphan
 *
 * @package App\Models
 */
class Vattu extends Model
{
	protected $table = 'vattu';
	public $timestamps = false;

	protected $casts = [
		'soluong' => 'int',
		'namsx' => 'int',
		'id_hocky' => 'int'
	];

	protected $fillable = [
		'ten',
		'dvt',
		'soluong',
		'dongia',
		'khaitoan',
		'dinhmuc',
		'mahieu',
		'nhanhieu',
		'namsx',
		'xuatxu',
		'hangsx',
		'cauhinh',
		'maHP',
		'caTH',
		'id_hocky'
	];

	public function hocky()
	{
		return $this->belongsTo(Hocky::class, 'id_hocky');
	}

	public function hocphan()
	{
		return $this->belongsTo(Hocphan::class, 'maHP');
	}
}
